<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

use App\Domains\User\Model\SiprRole;
use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasRole;

use App\Http\Requests\Users\UserRegisterRequest;

use App\Traits\Logs\CustomLogger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    use CustomLogger;

    public function registerForm()
    {

        return View::make('account.auth.registration');
    }

    public function submitFormRegister(UserRegisterRequest $request)
    {

        $register_input = $request->validated();

        $input_context = [
            SiprUser::USERNAME => $register_input[SiprUser::USERNAME],
            SiprUser::NAME => $register_input[SiprUser::NAME],
        ];

        DB::beginTransaction();

        $guest_role_record =
            SiprRole::select()
                ->where(SiprRole::ROLE, '=', SiprRole::GUEST)
                ->first()
            ??
            SiprRole::create([
                SiprRole::ROLE => SiprRole::GUEST,
            ]);

        $user_created_record_model = SiprUser::create([
            SiprUser::USERNAME => $register_input[SiprUser::USERNAME],
            SiprUser::NAME => $register_input[SiprUser::NAME],
            SiprUser::PASSWORD => password_hash($register_input[SiprUser::PASSWORD], PASSWORD_BCRYPT),
        ]);

        SiprUserHasRole::create([
            SiprUserHasRole::USER_ID => $user_created_record_model->getId(),
            SiprUserHasRole::ROLE_ID => $guest_role_record[SiprRole::ID],
        ]);

        $this->logInfoMessage(
            "User created with username: {" . SiprUser::USERNAME . "} with name: {" . SiprUser::NAME . "}",
            $input_context
        );

        DB::commit();

        return redirect()->route('login');
    }

    public function accountDetail(Request $request)
    {

        $user_model = Auth::user();

        $email_collection = null;
        $roles_collection = null;
        $phone_number_collection = null;

        $email_collection = $user_model->hasEmails;
        $phone_number_collection = $user_model->hasPhoneNumbers;
        $roles_collection = $user_model->hasRoles;

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
        Log::debug(sprintf('[class: %s] | [method: %s] | called.', static::class, __FUNCTION__));

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
}
