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
        $request_id = $request->session()->getId();
        Log::debug('Ensuring session_id: {session_id} already login.', ["session_id" => $request_id ?? null]);

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $request->getSession()->getId())
            ->first();

        if ($session_model === null) {
            Log::debug('Session_id {session_id} not yet login.', ["session_id" => $request_id ?? null]);
            return redirect(route('login'));
        }

        if ($session_model->user_id !== null) {
            Log::debug('Ensure user login with user_id: {user_id}', ["user_id" => $session_model->user_id]);
            return $next($request);
        }

        Log::debug('Session_id {session_id} not yet login.', ["session_id" => $request_id ?? null]);
        return redirect(route('login'));
    }
}
