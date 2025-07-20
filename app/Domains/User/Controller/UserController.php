<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasPhoneNumber;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function accountDetail(Request $request)
    {
        Log::debug("Controller: UserController | method: accountDetail | called.");

        $session_id = $request->session()->getId();

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_model = null;
        $email_collection = null;
        $phone_number_collection = null;
        $roles_collection = null;

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table.',
                [
                    "user_id" => $session_model->user_id
                ]
            );

            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();

            $email_collection = $user_model->hasEmails;
            $phone_number_collection = $user_model->hasPhoneNumbers;
            $roles_collection = $user_model->hasRoles;
        }

        if ($user_model !== null) {
            Log::debug(
                'User view his account with user id: {user_id} and username: {username}.',
                [
                    "user_id" => $user_model->getId(),
                    "username" => $user_model->getUsername()
                ]
            );
        }

        $current_page_email = LengthAwarePaginator::resolveCurrentPage('email_pages');
        $current_page_phone_number = LengthAwarePaginator::resolveCurrentPage('phone_number_pages');
        $current_page_role = LengthAwarePaginator::resolveCurrentPage('role_pages');

        $items_per_email_page = 1;
        $items_per_phone_page = 1;
        $items_per_role_page = 1;

        $current_items_on_email_active_page =
            $email_collection->slice(($current_page_email - 1) * $items_per_email_page, $items_per_email_page)
                ->values();

        $current_items_on_phone_number_active_page =
            $phone_number_collection->slice(($current_page_phone_number - 1) * $items_per_phone_page, $items_per_phone_page)
                ->values();

        $current_items_on_role_active_page =
            $roles_collection->slice(($current_page_role - 1) * $items_per_role_page, $items_per_role_page)
                ->values();

        $email_pagination = new LengthAwarePaginator(
            $current_items_on_email_active_page,
            $email_collection->count(),
            $items_per_email_page,
            $current_page_email,
            [
                "pageName" => "email_pages",
                "path" => $request->url(),
                "query" => $request->query(),
            ]
        );

        $phone_number_pagination = new LengthAwarePaginator(
            $current_items_on_phone_number_active_page,
            $phone_number_collection->count(),
            $items_per_phone_page,
            $current_page_phone_number,
            [
                "pageName" => "phone_number_pages",
                "path" => $request->url(),
                "query" => $request->query(),
            ]
        );

        $role_pagination = new LengthAwarePaginator(
            $current_items_on_role_active_page,
            $roles_collection->count(),
            $items_per_role_page,
            $current_page_role,
            [
                "pageName" => "role_pages",
                "path" => $request->url(),
                "query" => $request->query(),
            ]
        );

        return view('account.index')
            ->with('user_model', $user_model)
            ->with('email_model', $email_pagination)
            ->with('role_model', $role_pagination)
            ->with('phone_number_model', $phone_number_pagination);
    }

    public function listOfRegisteredAccount(Request $request)
    {
        Log::debug("Controller: UserController | method: listOfRegisteredAccount | called.");

        $user_account_paginate = SiprUser::select()
            ->with('hasEmails')
            ->with('hasRoles')
            ->with('hasPhoneNumbers')
            ->paginate(10)
            ->appends($request->query())
            ->withQueryString();

        return view('account.management.index')
            ->with('listOfAccount', $user_account_paginate);
    }

    public function addEmailForm(Request $request)
    {
        Log::debug("Controller: UserController | method: addEmailForm | called.");

        $session_id = $request->session()->getId();
        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_model = null;

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table.',
                [
                    "user_id" => $session_model->user_id
                ]
            );

            $user_model = SiprUser::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();
        }

        return view('account.management.email.add')
            ->with('username', $user_model->getUsername());
    }

    public function addPhoneNumberForm(Request $request)
    {
        Log::debug("Controller: UserController | method: addPhoneNumberForm | called.");
        
        $session_id = $request->session()->getId();
        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_model = null;

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table. user_id acquired.',
                [
                    "user_id" => $session_model->user_id
                ]
            );

            $user_model = SiprUser::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();
        }

        return view('account.management.phone.add')
            ->with('username', $user_model->getUsername());
    }

    public function editEmailForm(Request $request)
    {
        Log::debug("Controller: UserController | method: editEmailForm | called.");

        $session_id = $request->session()->getId();

        $user_model = null;
        $old_email = null;
        $email_model = null;
        $email_id = null;

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table.',
                ["user_id" => $session_model->user_id]
            );

            $user_model = SiprUser::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();
        }

        if ($user_model !== null && $user_model instanceof SiprUser) {
            $username = $user_model->getUsername();
        }

        if (isset($request->only("id")["id"])) {
            $email_id = $request->only("id")["id"];
        }

        $email_model = SiprSecondaryEmail::select()
            ->where(SiprSecondaryEmail::COLUMN_ID_ITS_NAME, '=', $email_id)
            ->first();

        if ($email_model !== null && $email_model instanceof SiprSecondaryEmail) {
            $old_email = $email_model->getEmail();
        }

        if ($email_model === null) {
            return $this->accountDetail($request);
        }

        return response()
            ->view('account.management.email.edit', ["username" => $username, "oldEmail" => $old_email]);
    }

    public function editPhoneNumberForm(Request $request)
    {
        Log::debug("Controller: UserController | method: editPhoneNumberForm | called.");

        $session_id = $request->session()->getId();

        $user_model = null;
        $old_phone_number = null;

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table.',
                ["user_id" => $session_model->user_id]
            );

            $user_model = SiprUser::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();
        }

        if ($user_model !== null && $user_model instanceof SiprUser) {
            $username = $user_model->getUsername();
        }

        if (isset($request->only("id")["id"])) {
            $phone_number_id = $request->only("id")["id"];

            $phone_number_model = SiprPhoneNumber::select()
                ->where(SiprPhoneNumber::COLUMN_ID_ITS_NAME, '=', $phone_number_id)
                ->first();

            $old_phone_number = $phone_number_model->phone_number;
        }

        return response()->view("account.management.phone.edit", ["username" => $username, "oldPhoneNumber" => $old_phone_number]);
    }

    public function submitAddPhoneNumberForm(Request $request)
    {
        Log::debug("Controller: UserController | method: submitAddPhoneNumberForm | called.");

        $session_id = $request->session()->getId();
        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_model = null;
        $user_id = null;

        $input = $request->only([
            "new-phone-number",
        ]);

        $phone_number_table_name = SiprPhoneNumber::TABLE_NAME;
        $phone_number_column_name = SiprPhoneNumber::COLUMN_PHONE_NUMBER_ITS_NAME;
        $user_id_column_name = SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME;
        $email_id_column_name = SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME;

        $validator = Validator::make($input, [
            "new-phone-number" => ['required', "unique:{$phone_number_table_name},{$phone_number_column_name}", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^"]
        ]);

        if ($validator->fails()) {
            $message = $validator->getMessageBag()->get('new-phone-number')[0];
            return $this->addPhoneNumberForm($request)->with('error_new_phone_number_input', $message);
        }

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table.',
                ["user_id" => $session_model->user_id]
            );

            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();

            $user_id = $user_model->getId();
        }

        $new_email_data = $input['new-phone-number'];

        DB::beginTransaction();

        $email_model = SiprPhoneNumber::create([
            "{$phone_number_column_name}" => $new_email_data
        ]);

        SiprUserHasPhoneNumber::create([
            "{$email_id_column_name}" => $email_model->getId(),
            "{$user_id_column_name}" => $user_id,
        ]);

        DB::commit();

        return redirect(route('account'));

        // return redirect(route('list-of-room'));
    }

    public function submitAddEmailForm(Request $request)
    {
        Log::debug("Controller: UserController | method: submitAddEmailForm | called.");

        $session_id = $request->session()->getId();
        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_model = null;
        $user_id = null;

        $input = $request->only([
            "new-email",
        ]);

        $email_table_name = SiprSecondaryEmail::TABLE_NAME;
        $email_column_name = SiprSecondaryEmail::COLUMN_EMAIL_ITS_NAME;
        $user_id_column_name = SiprUserHasSecondaryEmail::COLUMN_USER_ID_ITS_NAME;
        $email_id_column_name = SiprUserHasSecondaryEmail::COLUMN_EMAIL_ID_ITS_NAME;

        $validator = Validator::make($input, [
            "new-email" => ['required', "unique:{$email_table_name},{$email_column_name}", "email"]
        ]);

        if ($validator->fails()) {
            $message = $validator->getMessageBag()->get('new-email')[0];

            return $this->addEmailForm($request)->with('error_new_email_input', $message);
        }

        if ($session_model->user_id !== null) {
            Log::debug(
                'Search user_id: {user_id} from session table.',
                [
                    "user_id" => $session_model->user_id
                ]
            );

            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $session_model->user_id)
                ->first();

            $user_id = $user_model->getId();
        }

        $new_email_data = $input['new-email'];

        DB::beginTransaction();

        $email_model = SiprSecondaryEmail::create([
            "{$email_column_name}" => $new_email_data
        ]);

        SiprUserHasSecondaryEmail::create([
            "{$email_id_column_name}" => $email_model->getId(),
            "{$user_id_column_name}" => $user_id,
        ]);

        DB::commit();

        return redirect(route('account'));
    }
}
