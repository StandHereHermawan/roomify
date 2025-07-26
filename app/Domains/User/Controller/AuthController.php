<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;

use App\Domains\User\Request\UserLoginRequests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

/*
|
|   Auth here stands for authentication.
|   Authentication is stands for who are you in the system.
|   it was different from authorization.
|
*/
class AuthController extends Controller
{
    public function loginForm(Request $request)
    {
        Log::debug('class: AuthController | method: loginForm | called. session_id: {session_id}.', [
            "session_id" => $request->session()->getId(),
        ]);

        return view('account.auth.login');
    }

    public function submitFormLogin(UserLoginRequests $request)
    {
        Log::debug("class: AuthController | method: submitFormLogin | called.");

        $login_input = $request->validated();

        $username_input =
            $login_input["username"];

        $password_input =
            $login_input["password"];

        $user_registered = SiprUser::select()
            ->where(SiprUser::COLUMN_USERNAME_ITS_NAME, '=', $username_input)
            ->first();

        Log::debug(
            "class: AuthController | method: submitFormLogin | User try to authenticate. user_id: {id}, username: {username}, session_id: {session_id}.",
            ["id" => $user_registered->getId(), "username" => $username_input, "session_id" => $request->session()->getId()]
        );

        DB::beginTransaction();

        // 1.0.1 Simpan informasi ke kolom payload di tabel sipr_session.
        // Tapi bukan bikin kolom user_id di tabel sipr_sessions terisi.
        session([
            'user_id' => $user_registered->getId(),
            'user_name' => $user_registered->getUsername(),
        ]);

        DB::commit();

        // Auth::attempt sudah termasuk cek password input dan hashed password di database.
        if (Auth::attempt(["username" => $username_input, "password" => $password_input])) {

            $request->session()->regenerate();
            Log::info(
                "class: AuthController | method: submitFormLogin | User authenticated with user_id: {id}, username: {username}, session_id: {session_id}.",
                ["id" => $user_registered->getId(), "username" => $username_input, "session_id" => $request->session()->getId()]
            );
            return redirect()->route('dashboard');
        }

        return response(
            view("account.auth.login")->with("errorPasswordInput", "Username or Password wrong."),
            400
        );
    }

    public function submitLogout(Request $request)
    {
        $session = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $request->session()->getId())
            ->first();

        $user_registered = null;

        if ($session !== null) {
            $user_registered = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $session->user_id)
                ->first();
        }

        if ($user_registered !== null) {
            Log::info("User logout with user_id: {id} and username: {username}.", [
                "id" => $user_registered->getId(),
                "username" => $user_registered->getUsername(),
            ]);
        }

        DB::beginTransaction();

        $request->session()->flush(); // Hapus informasi 1.0.1 yang ada di function 'submitFormLogin()' di kolom payload table sipr_session.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        DB::commit();

        return redirect()->route('login');
    }
}
