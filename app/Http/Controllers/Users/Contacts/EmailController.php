<?php

namespace App\Http\Controllers\Users\Contacts;

use App\Http\Controllers\Controller;

use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;

use App\Http\Requests\Emails\AddEmailRequest;
use App\Http\Requests\Emails\DeleteEmailRequest;

use App\Policies\EmailPolicy;

use App\Traits\Logs\CustomLogger;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    use CustomLogger;

    public function addEmailForm()
    {
        $user_model = Auth::user();

        if ($user_model === null) {
            throw new HttpResponseException(
                response(redirect(route('login')), 401)
            );
        }

        Log::debug(
            'class: UserController | method: addEmailForm | Search user_id: {user_id} from session table.',
            ["user_id" => $user_model[SiprUser::ID]]
        );


        return view('account.management.email.add')
            ->with('username', $user_model->getUsername());
    }

    public function submitAddEmailForm(AddEmailRequest $request)
    {
        $user_model = Auth::user();
        $input = $request->validated();
        $new_email_data = $input['new-email'];

        if ($user_model === null) {
            throw new HttpResponseException(
                response(redirect(route('login')), 401)
            );
        }

        $log_context = [
            "id" => $user_model->getId(),
            "username" => $user_model->getUsername(),
            "email" => $new_email_data
        ];

        $this->logDebugMessage(
            __FUNCTION__,
            "user: {username} with id: {id} attempt to add email",
            $log_context
        );


        DB::beginTransaction();

        $email_model = SiprSecondaryEmail::create([
            SiprSecondaryEmail::EMAIL => $new_email_data
        ]);

        SiprUserHasSecondaryEmail::create([
            SiprUserHasSecondaryEmail::EMAIL_ID => $email_model->getId(),
            SiprUserHasSecondaryEmail::USER_ID => $user_model->getId(),
        ]);

        DB::commit();

        $this->logDebugMessage(
            __FUNCTION__,
            "user: {username} with id: {id} attempt to add email",
            $log_context
        );

        $this->logInfoMessage(
            "user: {username} added new email contacts. the email: {email}",
            $log_context
        );


        return redirect(route('account'));
    }

    public function editEmailForm(Request $request, $id)
    {
        $email_id = $request->only("id")["id"] ?? $id;
        $user_model = Auth::user();

        if ($user_model === null) {
            throw new HttpResponseException(
                response(redirect(route('login')), 401)
            );
        }

        $username = $user_model->getUsername();
        $user_id = $user_model->getId();

        $log_context = [
            "user_id" => $user_id ?? "no user id available",
            "id" => $email_id,
            "username" => $username ?? "no username available"
        ];

        if ($user_id !== null) {
            Log::debug(
                'class: UserController | method: editEmailForm | User accessing: {username} and user_id: {user_id}.',
                ["user_id" => $user_id ?? "no user id available", "username" => $username ?? "no username available"]
            );
        }

        $this->logDebugMessage(
            __FUNCTION__,
            "Attempt search email with id: {id}",
            $log_context
        );

        $email_model = SiprSecondaryEmail::select()
            ->where(SiprSecondaryEmail::ID, '=', $email_id)
            ->first();

        if ($email_model === null) {
            throw new HttpResponseException(
                response(redirect(route('account')), 404)
            );
        }

        $log_context = [
            "user_id" => $user_id ?? "no user id available",
            "id" => $email_id,
            "username" => $username ?? "no username available",
            "email" => $email_model->getEmail()
        ];

        $this->logDebugMessage(
            __FUNCTION__,
            "Email with id: {id} found. email was {email}",
            $log_context
        );

        Gate::authorize(EmailPolicy::UPDATE, $email_model);

        $old_email = $email_model->getEmail();


        return response()->view(
            'account.management.email.edit',
            ["username" => $username, "oldEmail" => $old_email]
        );
    }

    public function deleteEmail(DeleteEmailRequest $request)
    {
        $input = $request->validated();
        $user_model = Auth::user();

        if ($user_model === null) {
            throw new HttpResponseException(
                response(redirect(route('login')), 401)
            );
        }

        $username = null;
        $email = $input['old-email'];

        $operation_success = false;

        $username = $user_model->getUsername();

        $this->logDebugMessage(
            __FUNCTION__,
            "Email with id: {id} found. email was {email}",
            // $log_context
        );
        Log::debug(
            'class: UserController | method: deleteEmail | User: {username} attempt to delete email.',
            ["username" => $username]
        );

        Log::debug(
            'class: UserController | method: deleteEmail | Attempt search email: {email}.',
            ["email" => $email]
        );

        $email_record = SiprSecondaryEmail::select()
            ->where(SiprSecondaryEmail::EMAIL, '=', $email)
            ->first();

        if ($email_record === null) {
            throw new HttpResponseException(
                response(redirect(route('account')), 404)
            );
        }

        Log::debug(
            'class: UserController | method: deleteEmail | Email: {email} found.',
            ["email" => $email]
        );

        Log::debug(
            'class: UserController | method: deleteEmail | User: {username} attempt to delete email: {email}.',
            ["username" => $username]
        );

        Gate::authorize(EmailPolicy::DELETE, $email_record);

        $email_id = $email_record->getId();
        $user_has_email = SiprUserHasSecondaryEmail::select()
            ->where(SiprUserHasSecondaryEmail::EMAIL_ID, '=', $email_id)
            ->first();

        $operation_success = false;
        DB::transaction(function () use ($user_has_email, $email_record, &$operation_success) {
            $operation_success_delete_from_user_and_email_mapping_table = $user_has_email->delete();
            $operation_success_delete_from_email_table = $email_record->delete();
            $operation_success = $operation_success_delete_from_user_and_email_mapping_table & $operation_success_delete_from_email_table;
        });

        if (!$operation_success) {
            Log::info(
                'class: UserController | method: deleteEmail | User: {username} failed to delete it is own email: {email}.',
                ["username" => $username, "email" => $email]
            );

            throw new HttpResponseException(
                response(view('account.management.email.edit', ["username" => $username, "oldEmail" => $email])
                    ->with('error_updated_email_input', "Gagal menghapus email."), 422)
            );
        }

        if ($operation_success) {
            Log::info(
                'class: UserController | method: deleteEmail | User: {username} success delete it is own email: {email}.',
                ["username" => $username, "email" => $email]
            );



            return redirect(route('account'));
        }
    }
}
