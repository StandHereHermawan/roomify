<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Model\SiprSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use App\Domains\User\Model\SiprUser;
use Validator;

class AuthController extends Controller
{
    public function registerForm(Request $request)
    {
        $request;
        return view('account.auth.registration');
    }

    public function loginForm(Request $request)
    {
        $request;
        return view('account.auth.login');
    }

    public function submitFormRegister(Request $request)
    {
        $register_input = $request->only([
            "username",
            "name",
            "password",
            "agreedTermsOfUse"
        ]);

        Log::debug('Input Received.', [
            "url" => $request->url(),
            "input" => $register_input,
        ]);

        $validator = Validator::make($register_input, [
            "username" => ["required", "min:8", "max:255", "lowercase", "unique:sipr_users,username"],
            "name" => ["required", "min:8", "max:255"],
            "agreedTermsOfUse" => "required",
            "password" => [Password::min(8)->letters()->numbers()->symbols()->mixedCase()->max(100)]
        ], [
            "agreedTermsOfUse" => "Harus mengisi persetujuan penggunaan.",
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            return response(
                view("account.auth.registration")
                    ->with("errorUsernameInput", $errorMessage->get("username")[0] ?? null)
                    ->with("errorNameInput", $errorMessage->get("name")[0] ?? null)
                    ->with("errorPasswordInput", $errorMessage->get("password")[0] ?? null)
                    ->with("errorTermsOfUseInput", $errorMessage->get("agreedTermsOfUse")[0] ?? null)
                ,
                422
            );
        }

        $username_column_name = SiprUser::COLUMN_USERNAME_ITS_NAME;
        $name_column_name = SiprUser::COLUMN_NAME_ITS_NAME;
        $password_column_name = SiprUser::COLUMN_PASSWORD_ITS_NAME;

        DB::beginTransaction();

        SiprUser::create([
            "{$username_column_name}" => $register_input['username'],
            "{$name_column_name}" => $register_input['name'],
            "{$password_column_name}" => password_hash($register_input['password'], PASSWORD_BCRYPT),
        ]);

        DB::commit();

        return redirect()->route('login');
    }

    public function submitFormLogin(Request $request)
    {
        $login_input = $request->only([
            "username",
            "password",
        ]);

        $validator = Validator::make(
            $login_input,
            [
                "username" => ["required"],
                "password" => ["required"]
            ],
        );

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();
            return response(
                view("account.auth.login")
                    ->with("errorUsernameInput", $errorMessage->get("username")[0] ?? null)
                    ->with("errorPasswordInput", $errorMessage->get("password")[0] ?? null)
                ,
                400
            );
        }

        $username_input =
            $login_input["username"];

        $password_input =
            $login_input["password"];

        $user_registered = SiprUser::select()
            ->where(SiprUser::COLUMN_USERNAME_ITS_NAME, '=', $username_input)
            ->first();

        DB::beginTransaction();

        // 1.0.1 Simpan informasi ke kolom payload di tabel sipr_session.
        // Tapi bukan bikin kolom user_id di tabel sipr_sessions terisi.
        session([
            'user_id' => $user_registered->getId(),
            'user_name' => $user_registered->getUsername(),
        ]);

        DB::commit();

        // Auth::attempt sudah termasuk cek password input dan hashed password di database.
        if (Auth::attempt(["username" => $username_input, "password" => $password_input,])) {

            $request->session()->regenerate();
            Log::info("User login With user_id: {id}.", ["id" => $user_registered->getId()]);
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
            Log::info("User logout with user_id: {id}.", [
                "id" => $user_registered->getId(),
            ]);
        }


        DB::beginTransaction();

        $request->session()->flush(); // Hapus informasi 1.0.1 di kolom payload
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        DB::commit();

        return redirect()->route('login');
    }
}
