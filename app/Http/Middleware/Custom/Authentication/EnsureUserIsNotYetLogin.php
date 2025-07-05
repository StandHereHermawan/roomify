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
        Log::debug('Ensuring session_id: {session_id} not yet login.', ["session_id" => $request->session()->getId() ?? null]);
        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $request->getSession()->getId())
            ->first();

        if ($session_model === null) {
            return $next($request);
        }

        if ($session_model->user_id === null) {
            Log::debug('Session_id {session_id} not yet login.', ["session_id" => $request->session()->getId() ?? null]);
            return $next($request);
        }

        if ($session_model->user_id !== null) {
            Log::debug('Session_id: {session_id} already login with user_id: {user_id}.', ["session_id" => $request->session()->getId() ?? null, "user_id" => $session_model->user_id]);
        }

        return redirect(route('list-of-room'));
    }
}
