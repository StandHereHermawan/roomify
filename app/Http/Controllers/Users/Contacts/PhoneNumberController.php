<?php

namespace App\Http\Controllers\Users\Contacts;

use App\Http\Controllers\Controller;

use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasPhoneNumber;

use App\Http\Requests\PhoneNumbers\CreatePhoneNumberRequest;
use App\Http\Requests\PhoneNumbers\DeletePhoneNumberRequest;

use App\Policies\PhoneNumberPolicy;

use App\Traits\Logs\CustomLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\View;

class PhoneNumberController extends Controller
{
    use CustomLogger;

    public function addPhoneNumberForm()
    {
        $this->logDebugStart(
            __FUNCTION__
        );
        $millis_start = microtime(true);

        $user_model = Auth::user();

        if ($user_model === null) {
            $this->logDebugFinish(
                __FUNCTION__,
                [],
                $millis_start
            );
            throw new HttpResponseException(
                response(redirect(route('login')), 401)
            );
        }

        $username = $user_model->getUsername();

        $this->logDebugFinish(
            __FUNCTION__,
            [],
            $millis_start
        );

        return view('account.management.phone.add')
            ->with('username', $username);
    }

    public function submitAddPhoneNumberForm(CreatePhoneNumberRequest $request)
    {
        $this->logDebugStart(__FUNCTION__);
        $millis_start = microtime(true);

        $user_model = Auth::user();
        $input = $request->validated();

        if ($user_model === null) {
            throw new HttpResponseException(
                response(redirect(route('login')), 401)
            );
        }

        $new_phone_number_data = $input['new-phone-number'];

        $log_context = [
            "phone" => $new_phone_number_data,
            "username" => $user_model->getUsername()
        ];

        DB::beginTransaction();

        $this->logDebugMessage(
            __FUNCTION__,
            "Attempt to save new phone number. the phone number: {phone}",
            $log_context
        );

        $email_model = SiprPhoneNumber::create([
            SiprPhoneNumber::PHONE_NUMBER => $new_phone_number_data
        ]);

        $this->logDebugMessage(
            __FUNCTION__,
            "attempt to assign the phone number: {phone} to username: {username}",
            $log_context
        );

        SiprUserHasPhoneNumber::create([
            SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME => $email_model->getId(),
            SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME => $user_model->getId(),
        ]);

        $this->logInfoMessage(
            "user: {username} added new phone number contacts. the phone: {phone}",
            $log_context
        );

        DB::commit();

        $this->logDebugFinish(
            __FUNCTION__,
            [],
            $millis_start
        );

        return redirect(route('account'));
    }

    public function editPhoneNumberForm(Request $request, $id)
    {
        $this->logDebugStart(__FUNCTION__);
        $millis_start = microtime(true);

        $user_model = Auth::user();

        if ($user_model !== null) {
            $this->logDebugMessage(
                __FUNCTION__,
                "User already login. attempt to edit phone number"
            );

            $username =
                $user_model->getUsername();
            $user_id =
                $user_model->getId();
        }

        $old_phone_number_id = $request->only("id")["id"] ?? $id;

        $log_context = [
            "user_id" => $user_id ?? "no user id available",
            "username" => $username ?? "no username available",
            "id" => $old_phone_number_id
        ];

        if ($user_id !== null) {
            $this->logDebugMessage(
                __FUNCTION__,
                "User accessing: {username} and user_id: {user_id}",
                $log_context
            );
        }

        if ($old_phone_number_id !== null) {
            $this->logDebugMessage(
                __FUNCTION__,
                "Attempt search phone number with id: {id}",
                $log_context
            );
        }

        $old_phone_number_model = SiprPhoneNumber::select()
            ->where(SiprPhoneNumber::COLUMN_ID_ITS_NAME, '=', $old_phone_number_id)
            ->first();

        if ($old_phone_number_model === null) {
            throw new HttpResponseException(
                response(redirect(route('account')), 404)
            );
        }

        $this->logDebugMessage(
            __FUNCTION__,
            "Phone Number with id: {id} retrieved. Phone Number was {email}",
            $log_context
        );

        Gate::authorize(PhoneNumberPolicy::UPDATE, $old_phone_number_model);

        $this->logDebugFinish(
            __FUNCTION__,
            [],
            $millis_start
        );

        return response(
            view("account.management.phone.edit")
                ->with("username", $username)
                ->with("oldPhoneNumber", $old_phone_number_model[SiprPhoneNumber::PHONE_NUMBER])
        );
    }

    public function deletePhoneNumber(DeletePhoneNumberRequest $request)
    {
        $this->logDebugStart(__FUNCTION__);
        $millis_start = microtime(true);

        $input = $request->validated();
        $phone_number = $input['old-phone-number'];

        $user_model = Auth::user();

        if ($user_model === null) {
            throw new HttpResponseException(
                response(redirect(route('login')), 404)
            );
        }

        $username = $user_model->getUsername();

        $log_context = [
            "phone" => $phone_number,
            "username" => $username
        ];

        $this->logDebugMessage(
            __FUNCTION__,
            "User: {username} attempt to delete phone number",
            $log_context
        );

        $this->logDebugMessage(
            __FUNCTION__,
            "Attempt search phone number: {phone}",
            $log_context
        );

        $email_record = SiprPhoneNumber::select()
            ->where(SiprPhoneNumber::PHONE_NUMBER, '=', $phone_number)
            ->first();

        if ($email_record === null) {
            throw new HttpResponseException(
                response(redirect(route('account')), 404)
            );
        }

        $this->logDebugMessage(
            __FUNCTION__,
            "phone number: {phone} retrieved",
            $log_context
        );

        $this->logDebugMessage(
            __FUNCTION__,
            "User: {username} attempt to delete phone number: {phone}",
            $log_context
        );

        $email_id = $email_record->getId();

        $user_has_phone_number = SiprUserHasPhoneNumber::select()
            ->where(SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME, '=', $email_id)
            ->first();

        DB::beginTransaction();

        $user_has_phone_number->delete();
        $email_record->delete();

        DB::commit();

        $this->logDebugFinish(
            __FUNCTION__,
            [],
            $millis_start
        );

        return redirect(route('account'));

    }
}
