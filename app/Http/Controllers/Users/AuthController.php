<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

use App\Traits\Logs\CustomLogger;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Domains\User\Model\SiprUser;

use App\Http\Requests\Auth\LoginRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 *|
 *|   Auth here stands for authentication.
 *|   Authentication is stands for who are you in the system.
 *|   it was different from authorization.
 *|
 */
class AuthController extends Controller
{
    use CustomLogger;

    public function loginForm()
    {
        $this->logDebugStart(__FUNCTION__, []);
        $millis_start = microtime(true);

        $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return view('account.auth.login');
    }

    public function submitFormLogin(LoginRequest $request)
    {
        $this->logDebugStart(__FUNCTION__, []);
        $millis_start = microtime(true);

        $login_input = $request->validated();
        $user_record = SiprUser::select()
            ->where(SiprUser::USERNAME, '=', $login_input[SiprUser::USERNAME])
            ->first();

        $logContext = [
            SiprUser::ID => $user_record->getId(),
            SiprUser::USERNAME => $user_record->getUsername(),
        ];

        $this->logDebugMessage(
            __FUNCTION__,
            "User with username: {" . SiprUser::USERNAME . "} and user_id: {" . SiprUser::ID . "} try to authenticate",
            $logContext
        );

        $credentials = [
            SiprUser::USERNAME => $login_input[SiprUser::USERNAME],
            SiprUser::PASSWORD => $login_input[SiprUser::PASSWORD]
        ];

        /**
         *|
         *| Auth::attempt sudah termasuk cek password input dan hashed password di database.
         */
        if (Auth::attempt($credentials)) {

            DB::beginTransaction();
            /**
             *| 1.0.1 Simpan informasi ke kolom payload di tabel sipr_session.
             *| Tapi bukan bikin kolom user_id di tabel sipr_sessions terisi.
             */
            session([
                SiprUser::TABLE_NAME . "." . SiprUser::ID => $user_record->getId(),
                SiprUser::TABLE_NAME . "." . SiprUser::USERNAME => $user_record->getUsername(),
            ]);
            $request->session()->regenerate();
            DB::commit();

            $logContext = [
                SiprUser::ID => $user_record->getId(),
                SiprUser::USERNAME => $user_record->getUsername(),
            ];

            $this->logDebugMessage(
                __FUNCTION__,
                "User authenticated username: {username} and user_id: {id}",
                $logContext
            );
            $this->logInfoMessage(
                "User authenticated username: {username} and user_id: {id}",
                $logContext
            );

            $this->logInfoFinish(__FUNCTION__, [], $millis_start);
            return redirect()->route('dashboard');
        }

        $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        throw new HttpResponseException(response(
            view("account.auth.login")->with("errorPasswordInput", "Username or Password wrong."),
            401
        ));
    }

    public function submitLogout(Request $request)
    {
        $this->logDebugStart(__FUNCTION__, []);
        $millis_start = microtime(true);

        $user_model = Auth::user();
        $logContext = [
            SiprUser::ID => $user_model->getId(),
            SiprUser::USERNAME => $user_model->getUsername(),
        ];

        if ($user_model !== null) {
            $this->logInfoMessage(
                "User logout with user_id: {id} and username: {username}",
                $logContext
            );

            DB::beginTransaction();

            Auth::logout();
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            DB::commit();
        }

        $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return redirect()->route('login');
    }
}
