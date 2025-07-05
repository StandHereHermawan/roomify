<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function accountDetail(Request $request)
    {
        $session_id = $request->session()->getId();

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_model = null;
        $email_collection = null;
        $phone_number_collection = null;

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

            $email_collection = $user_model->hasEmails;
            $phone_number_collection = $user_model->hasPhoneNumbers;
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
        $items_per_email_page = 1;
        $items_per_phone_page = 1;

        $current_items_on_email_active_page =
            $email_collection->slice(($current_page_email - 1) * $items_per_email_page, $items_per_email_page)->values();

        $current_items_on_phone_number_active_page =
            $phone_number_collection->slice(($current_page_phone_number - 1) * $items_per_phone_page, $items_per_phone_page)->values();

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

        return view('account.index')
            ->with('user_model', $user_model)
            ->with('email_model', $email_pagination)
            ->with('phone_number_model', $phone_number_pagination)
        ;
    }

    public function listOfRegisteredAccount(Request $request)
    {
        $user_account_paginate = SiprUser::select()
            ->paginate(10)
            ->appends($request->query())
            ->withQueryString();

        return view('account.management.index')->with('listOfAccount', $user_account_paginate);
    }
}
