<?php

namespace App\Http\Middleware\Custom\Authentication;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

use App\Domains\User\Model\SiprSession;

class EnsureUserIsNotYetLogin
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
            'class: EnsureUserIsNotYetLogin | method: handle | Ensuring session_id: {session_id} state in database.',
            ["session_id" => $session_id ?? null]
        );

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_id = null;

        if ($session_model === null) {
            Log::debug(
                'class: EnsureUserIsNotYetLogin | method: handle | session_id: {session_id} not registered in database.',
                ["session_id" => $session_id ?? null]
            );

            return $next($request);
        }

        if ($session_model !== null) {
            Log::debug(
                'class: EnsureUserIsNotYetLogin | method: handle | session_id: {session_id} registered in database.',
                ["session_id" => $session_id ?? null]
            );

            $user_id = $session_model->getUserId();
        }

        if ($user_id === null) {
            Log::debug(
                'class: EnsureUserIsNotYetLogin | method: handle | session_id: {session_id} not yet login.',
                ["session_id" => $request->session()->getId() ?? null]
            );

            return $next($request);
        }

        if ($user_id !== null) {
            Log::debug(
                'class: EnsureUserIsNotYetLogin | method: handle | session_id: {session_id} already login with user_id: {user_id}. Redirect to {route}',
                ["session_id" => $request->session()->getId() ?? null, "user_id" => $session_model->user_id, "route" => route('dashboard')]
            );
        }

        return redirect(route('dashboard'));
    }
}
