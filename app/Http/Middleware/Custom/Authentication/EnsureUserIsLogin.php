<?php

namespace App\Http\Middleware\Custom\Authentication;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Symfony\Component\HttpFoundation\Response;

use App\Domains\User\Model\SiprSession;

class EnsureUserIsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session_id = $request->session()->getId();

        Log::debug(
            'class: EnsureUserIsLogin | method: handle | Ensuring session_id: {session_id} state in database.',
            ["session_id" => $session_id ?? null]
        );

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_id = null;

        if ($session_model === null) {
            Log::debug(
                'class: EnsureUserIsLogin | method: handle | session_id: {session_id} not registered in database.',
                ["session_id" => $session_id ?? null]
            );

            Log::debug(
                'class: EnsureUserIsLogin | method: handle | checking cookie value caused session_id: {session_id} not registered in database.',
                ["session_id" => $session_id ?? null]
            );

            $cookie_value = decrypt($request->cookie(config('session.cookie')), false);

            Log::debug(
                'class: EnsureUserIsLogin | method: handle | decrypted cookie: {cookie}.',
                ["cookie" => $cookie_value ?? null]
            );

            list($hmac, $session_id_from_cookie) = explode('|', $cookie_value);

            Log::debug(
                'class: EnsureUserIsLogin | method: handle | session_id_from_cookie: {session_id}, with hmac: {hmac}.',
                ["session_id" => $session_id_from_cookie ?? null, "hmac" => $hmac]
            );

            $session_id = $session_id_from_cookie;

            Log::debug(
                'class: EnsureUserIsLogin | method: handle | Ensuring session_id: {session_id} from cookie has state in database..',
                ["session_id" => $session_id ?? null]
            );
        }

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        if ($session_model === null) {
            Log::debug(
                'class: EnsureUserIsLogin | method: handle | session_id: {session_id} from cookie not registered in database.',
                ["session_id" => $session_id ?? null]
            );

            return redirect(route('login'), );
        }

        if ($session_model !== null) {
            Log::debug(
                'class: EnsureUserIsLogin | method: handle | session_id: {session_id} registered in database.',
                ["session_id" => $session_id ?? null]
            );

            $user_id = $session_model->getUserId();
        }

        if ($user_id === null) {
            Log::debug(
                'class: EnsureUserIsLogin | method: handle | session_id: {session_id} not yet login.',
                ["user_id" => $session_model->user_id, "session_id" => $session_id ?? null]
            );

            return redirect(route('login'), );
        }

        if ($user_id !== null) {
            Log::debug(
                'class: EnsureUserIsLogin | method: handle | session_id: {session_id} already login with user_id: {user_id}.',
                ["user_id" => $session_model->user_id, "session_id" => $session_id ?? null]
            );

            return $next($request);
        }

        Log::debug(
            'class: EnsureUserIsLogin | method: handle | session_id: {session_id} not yet login.',
            ["session_id" => $session_id ?? null]
        );
        return redirect(route('login'), );
    }
}
