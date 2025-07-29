<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprRole;
use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasPhoneNumber;
use App\Domains\User\Model\SiprUserHasRole;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;

use App\Domains\User\Request\UserAddPhoneNumberRequests;
use App\Domains\User\Request\UserRegistrationRequests;
use App\Domains\User\Request\UserAddEmailRequests;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function registerForm(Request $request)
    {
        Log::debug('class: UserController | method: registerForm | called. session_id: {session_id}.', [
            "session_id" => $request->session()->getId(),
        ]);

        return view('account.auth.registration');
    }

    public function submitFormRegister(UserRegistrationRequests $request)
    {
        Log::debug('class: UserController | method: submitFormRegister | called.');

        $register_input = $request->validated();

        $username_column_name = SiprUser::COLUMN_USERNAME_ITS_NAME;
        $name_column_name = SiprUser::COLUMN_NAME_ITS_NAME;
        $password_column_name = SiprUser::COLUMN_PASSWORD_ITS_NAME;
        $role_column_name = SiprRole::COLUMN_ROLE_ITS_NAME;
        $user_id_column_name = SiprUserHasRole::COLUMN_USER_ID_ITS_NAME;
        $role_id_column_name = SiprUserHasRole::COLUMN_ROLE_ID_ITS_NAME;

        $guest_role_record = SiprRole::select()->where(SiprRole::COLUMN_ROLE_ITS_NAME, '=', SiprRole::GUEST_ROLE)->first();
        $guest_role_id = null;

        DB::beginTransaction();

        $user_created_record_model = SiprUser::create([
            "{$username_column_name}" => $register_input['username'],
            "{$name_column_name}" => $register_input['name'],
            "{$password_column_name}" => password_hash($register_input['password'], PASSWORD_BCRYPT),
        ]);

        if ($guest_role_record === null) {
            $guest_role_record = SiprRole::create([
                "{$role_column_name}" => SiprRole::GUEST_ROLE,
            ]);
        }

        if ($guest_role_record !== null) {
            # code...
            $guest_role_id = $guest_role_record->getId();
        }

        SiprUserHasRole::create([
            "{$user_id_column_name}" => $user_created_record_model->getId(),
            "{$role_id_column_name}" => $guest_role_id,
        ]);

        Log::info('class: UserController | method: submitFormRegister | user created with username: {input}, session_id: {session_id}', [
            "input" => $register_input['username'],
            "session_id" => $request->session()->getId(),
        ]);

        DB::commit();

        return redirect()->route('login');
    }

    public function accountDetail(Request $request)
    {
        $user_id = null;
        $session_id = null;

        $user_model = null;
        $session_model = null;

        $email_collection = null;
        $roles_collection = null;
        $phone_number_collection = null;

        Log::debug("class: UserController | method: accountDetail | called.");

        $session_id = $request->session()->getId();
        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        if ($session_model !== null) {
            Log::debug(
                'class: UserController | method: accountDetail | session_id: {session_id} registered in database.',
                ["session_id" => $session_id]
            );

            $user_id = $session_model->user_id;
        }

        if ($session_model->user_id !== null) {
            Log::debug(
                'class: UserController | method: accountDetail | session_id: {session_id} has user_id: {user_id}.',
                ["user_id" => $session_model->user_id, "session_id" => $session_id]
            );

            $user_id = $session_model->user_id;
        }

        if ($user_id !== null) {
            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $user_id)
                ->first();
        }

        if ($user_model !== null) {
            Log::debug(
                'class: UserController | method: accountDetail | User view his account with user id: {user_id} and username: {username}.',
                [
                    "user_id" => $user_model->getId(),
                    "username" => $user_model->getUsername()
                ]
            );

            $email_collection = $user_model->hasEmails;
            $phone_number_collection = $user_model->hasPhoneNumbers;
            $roles_collection = $user_model->hasRoles;
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
        Log::debug("class: UserController | method: listOfRegisteredAccount | called.");

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
        Log::debug("class: UserController | method: addEmailForm | called.");

        $user_id = null;
        $user_model = null;
        $session_model = null;
        $session_id_from_cookie = null;
        $cookie_value = $request->cookie(config('session.cookie'));

        Log::debug(
            'class: UserController | method: addEmailForm | retrieved cookie with length: {len} from request, its value: {cookie}.',
            ["cookie" => $cookie_value ?? null, "len" => strlen($cookie_value)]
        );

        if (strlen($cookie_value) >= 41) {
            Log::debug('class: UserController | method: addEmailForm | the cookie_value length is more than 40.');
            Log::debug('class: UserController | method: addEmailForm | assuming cookie_value is encrypted caused by its length more than 40.');
            Log::debug('class: UserController | method: addEmailForm | attempt to decrypt cookie_value.');

            $decrypted_cookie = decrypt($cookie_value, false);

            Log::debug('class: UserController | method: addEmailForm | decrypted cookie_value: {cookie}.', ["cookie" => $decrypted_cookie]);
            Log::debug('class: UserController | method: addEmailForm | decrypted cookie_value its length: {cookie_length}.', ["cookie_length" => strlen($decrypted_cookie)]);
            Log::debug('class: UserController | method: addEmailForm | attempt to retrieve session_id from decrypted cookie value.');

            list($hmac, $session_id_from_decrypted_cookie) = explode('|', $decrypted_cookie);

            Log::debug('class: UserController | method: addEmailForm | retrieved from decrypted cookie session_id: {from_cookie}.', ["from_cookie" => $session_id_from_decrypted_cookie]);
            Log::debug('class: UserController | method: addEmailForm | retrieved from decrypted cookie hmac: {hmac}.', ["hmac" => $hmac]);
            Log::debug('class: UserController | method: addEmailForm | attempt to check session_id from decrypted cookie value state in database.');

            $session_id_from_cookie = $session_id_from_decrypted_cookie;
        }

        if (strlen($cookie_value) <= 40) {
            Log::debug('class: UserController | method: addEmailForm | the cookie_value length is doesnt beyond than 40.');
            Log::debug('class: UserController | method: addEmailForm | assuming cookie_value is not encrypted caused by its doesnt beyond than 40.');
            Log::debug('class: UserController | method: addEmailForm | attempt to check not encrypted cookie_value state in database.');

            $session_id_from_cookie = $cookie_value;
        }

        if ($session_id_from_cookie !== null) {
            $session_model = SiprSession::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id_from_cookie)
                ->first();
        }

        if ($session_model !== null) {
            Log::debug('class: UserController | method: addEmailForm | session_id: {session_id} was exist in database.', ["session_id" => $session_id_from_cookie]);
            $user_id = $session_model->getUserId();
        }

        if ($user_id !== null) {
            Log::debug(
                'class: UserController | method: addEmailForm | Search user_id: {user_id} from session table.',
                ["user_id" => $user_id]
            );

            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $user_id)
                ->first();

            return view('account.management.email.add')
                ->with('username', $user_model->getUsername());
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function submitAddEmailForm(UserAddEmailRequests $request)
    {
        Log::debug("class: UserController | method: submitAddEmailForm | called.");

        $email_column_name = SiprSecondaryEmail::COLUMN_EMAIL_ITS_NAME;
        $user_id_column_name = SiprUserHasSecondaryEmail::COLUMN_USER_ID_ITS_NAME;
        $email_id_column_name = SiprUserHasSecondaryEmail::COLUMN_EMAIL_ID_ITS_NAME;

        $user_id = null;
        $user_model = null;
        $session_model = null;
        $session_id_from_cookie = null;
        $cookie_value = $request->cookie(config('session.cookie'));

        Log::debug(
            'class: UserController | method: submitAddEmailForm | retrieved cookie with length: {len} from request, its value: {cookie}.',
            ["cookie" => $cookie_value ?? null, "len" => strlen($cookie_value)]
        );

        $input = $request->validated();

        if (strlen($cookie_value) >= 41) {
            Log::debug('class: UserController | method: submitAddEmailForm | the cookie_value length is more than 40.');
            Log::debug('class: UserController | method: submitAddEmailForm | assuming cookie_value is encrypted caused by its length more than 40.');
            Log::debug('class: UserController | method: submitAddEmailForm | attempt to decrypt cookie_value.');

            $decrypted_cookie = decrypt($cookie_value, false);

            Log::debug('class: UserController | method: submitAddEmailForm | decrypted cookie_value: {cookie}.', ["cookie" => $decrypted_cookie]);
            Log::debug('class: UserController | method: submitAddEmailForm | decrypted cookie_value its length: {cookie_length}.', ["cookie_length" => strlen($decrypted_cookie)]);
            Log::debug('class: UserController | method: submitAddEmailForm | attempt to retrieve session_id from decrypted cookie value.');

            list($hmac, $session_id_from_decrypted_cookie) = explode('|', $decrypted_cookie);

            Log::debug('class: UserController | method: submitAddEmailForm | retrieved from decrypted cookie session_id: {from_cookie}.', ["from_cookie" => $session_id_from_decrypted_cookie]);
            Log::debug('class: UserController | method: submitAddEmailForm | retrieved from decrypted cookie hmac: {hmac}.', ["hmac" => $hmac]);
            Log::debug('class: UserController | method: submitAddEmailForm | attempt to check session_id from decrypted cookie value state in database.');

            $session_id_from_cookie = $session_id_from_decrypted_cookie;
        }

        if (strlen($cookie_value) <= 40) {
            Log::debug('class: UserController | method: submitAddEmailForm | the cookie_value length is doesnt beyond than 40.');
            Log::debug('class: UserController | method: submitAddEmailForm | assuming cookie_value is not encrypted caused by its doesnt beyond than 40.');
            Log::debug('class: UserController | method: submitAddEmailForm | attempt to check not encrypted cookie_value state in database.');

            $session_id_from_cookie = $cookie_value;
        }

        if ($session_id_from_cookie !== null) {
            $session_model = SiprSession::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id_from_cookie)
                ->first();
        }

        if ($session_model !== null) {
            Log::debug('class: UserController | method: submitAddEmailForm | session_id: {session_id} was exist in database.', ["session_id" => $session_id_from_cookie]);
            $user_id = $session_model->getUserId();
        }

        if ($user_id !== null) {
            Log::debug(
                'class: UserController | method: submitAddEmailForm | Search user_id: {user_id} from session table.',
                ["user_id" => $session_model->user_id]
            );

            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $user_id)
                ->first();

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

            Log::info(
                'class: UserController | method: submitAddPhoneNumberForm | user: {username} added new email contacts. the email: {phone}.',
                ["username" => $user_model->getUsername() ?? null, "phone" => $new_email_data]
            );

            return redirect(route('account'));
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function addPhoneNumberForm(Request $request)
    {
        Log::debug("class: UserController | method: addPhoneNumberForm | called.");

        $user_id = null;
        $username = null;
        $user_model = null;
        $session_model = null;
        $session_id_from_cookie = null;
        $cookie_value = $request->cookie(config('session.cookie'));

        Log::debug(
            'class: UserController | method: addPhoneNumberForm | retrieved cookie with length: {len} from request, its value: {cookie}.',
            ["cookie" => $cookie_value ?? null, "len" => strlen($cookie_value)]
        );

        if (strlen($cookie_value) >= 41) {
            Log::debug('class: UserController | method: addPhoneNumberForm | the cookie_value length is more than 40.');
            Log::debug('class: UserController | method: addPhoneNumberForm | assuming cookie_value is encrypted caused by its length more than 40.');
            Log::debug('class: UserController | method: addPhoneNumberForm | attempt to decrypt cookie_value.');

            $decrypted_cookie = decrypt($cookie_value, false);

            Log::debug('class: UserController | method: addPhoneNumberForm | decrypted cookie_value: {cookie}.', ["cookie" => $decrypted_cookie]);
            Log::debug('class: UserController | method: addPhoneNumberForm | decrypted cookie_value its length: {cookie_length}.', ["cookie_length" => strlen($decrypted_cookie)]);
            Log::debug('class: UserController | method: addPhoneNumberForm | attempt to retrieve session_id from decrypted cookie value.');

            list($hmac, $session_id_from_decrypted_cookie) = explode('|', $decrypted_cookie);

            Log::debug('class: UserController | method: addPhoneNumberForm | retrieved from decrypted cookie session_id: {from_cookie}.', ["from_cookie" => $session_id_from_decrypted_cookie]);
            Log::debug('class: UserController | method: addPhoneNumberForm | retrieved from decrypted cookie hmac: {hmac}.', ["hmac" => $hmac]);
            Log::debug('class: UserController | method: addPhoneNumberForm | attempt to check session_id from decrypted cookie value state in database.');

            $session_id_from_cookie = $session_id_from_decrypted_cookie;
        }

        if (strlen($cookie_value) <= 40) {
            Log::debug('class: UserController | method: addPhoneNumberForm | the cookie_value length is doesnt beyond than 40.');
            Log::debug('class: UserController | method: addPhoneNumberForm | assuming cookie_value is not encrypted caused by its doesnt beyond than 40.');
            Log::debug('class: UserController | method: addPhoneNumberForm | attempt to check not encrypted cookie_value state in database.');

            $session_id_from_cookie = $cookie_value;
        }

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id_from_cookie)
            ->first();

        if ($session_model !== null) {
            $user_id = $session_model->getUserId();
        }

        if ($user_id !== null) {
            $user_model = SiprUser::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $user_id)
                ->first();
            $username = $user_model->getUsername();

            return view('account.management.phone.add')
                ->with('username', $username);
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function submitAddPhoneNumberForm(UserAddPhoneNumberRequests $request)
    {
        Log::debug("class: UserController | method: submitAddPhoneNumberForm | called.");

        $email_id_column_name = SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME;
        $phone_number_column_name = SiprPhoneNumber::COLUMN_PHONE_NUMBER_ITS_NAME;
        $user_id_column_name = SiprUserHasPhoneNumber::COLUMN_USER_ID_ITS_NAME;

        $user_id = null;
        $user_model = null;
        $session_model = null;
        $session_id_from_cookie = null;
        $cookie_value = Cookie::get(config('session.cookie'));

        Log::debug(
            'class: UserController | method: submitAddPhoneNumberForm | retrieved cookie with length: {len} from request, its value: {cookie}.',
            ["cookie" => $cookie_value ?? null, "len" => strlen($cookie_value)]
        );

        if (strlen($cookie_value) >= 41) {
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | the cookie_value length is more than 40.');
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | assuming cookie_value is encrypted caused by its length more than 40.');
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt to decrypt cookie_value.');

            $decrypted_cookie = decrypt($cookie_value, false);

            Log::debug('class: UserController | method: submitAddPhoneNumberForm | decrypted cookie_value: {cookie}.', ["cookie" => $decrypted_cookie]);
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | decrypted cookie_value its length: {cookie_length}.', ["cookie_length" => strlen($decrypted_cookie)]);
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt to retrieve session_id from decrypted cookie value.');

            list($hmac, $session_id_from_decrypted_cookie) = explode('|', $decrypted_cookie);

            Log::debug('class: UserController | method: submitAddPhoneNumberForm | retrieved from decrypted cookie session_id: {from_cookie}.', ["from_cookie" => $session_id_from_decrypted_cookie]);
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | retrieved from decrypted cookie hmac: {hmac}.', ["hmac" => $hmac]);
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt to check session_id from decrypted cookie value state in database.');

            $session_id_from_cookie = $session_id_from_decrypted_cookie;
        }

        if (strlen($cookie_value) <= 40) {
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | the cookie_value length is doesnt beyond than 40.');
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | assuming cookie_value is not encrypted caused by its doesnt beyond than 40.');
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt to check not encrypted cookie_value state in database.');

            $session_id_from_cookie = $cookie_value;
        }

        if ($session_id_from_cookie !== null) {
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt check session_id state in database from decrypted cookie value.');
            $session_model = SiprSession::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id_from_cookie)
                ->first();
        }

        if ($session_model !== null) {
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | session_id: {session_id} was exist in database.', ["session_id" => $session_id_from_cookie]);
            $user_id = $session_model->getUserId();
        }

        if ($user_id !== null) {
            Log::debug('class: UserController | method: submitAddPhoneNumberForm | session_id: {session_id} was owned by user with id: {id}.', ["session_id" => $session_id_from_cookie, "id" => $user_id]);

            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $user_id)
                ->first();

            $input = $request->validated();
            $new_phone_number_data = $input['new-phone-number'];

            DB::beginTransaction();

            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt to save new phone number. the phone number: {phone}', ["phone" => $new_phone_number_data]);
            $email_model = SiprPhoneNumber::create([
                "{$phone_number_column_name}" => $new_phone_number_data
            ]);

            Log::debug('class: UserController | method: submitAddPhoneNumberForm | attempt to assign the phone number: {phone} to username: {username}', ["phone" => $new_phone_number_data, "username" => $user_model->getUsername()]);
            SiprUserHasPhoneNumber::create([
                "{$email_id_column_name}" => $email_model->getId(),
                "{$user_id_column_name}" => $user_id,
            ]);

            Log::info(
                'class: UserController | method: submitAddPhoneNumberForm | user: {username} added new phone number contacts. the phone: {phone}.',
                ["username" => $user_model->getUsername() ?? null, "phone" => $new_phone_number_data]
            );

            DB::commit();

            return redirect(route('account'));
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function editEmailForm(Request $request)
    {
        Log::debug("class: UserController | method: editEmailForm | called.");

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
        Log::debug("class: UserController | method: editPhoneNumberForm | called.");

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
}
