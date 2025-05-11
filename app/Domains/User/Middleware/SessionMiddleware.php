<?php

namespace App\Domains\User\Middleware;

use App\Domains\User\Controller\AccountManagementController;
use App\Domains\User\Model\SiprUserHasSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $siprToken = $request->cookie("X-SIPR-TOKEN");

        $userHasSessionModel = null;
        $sessionExpiredAt = null;

        if ($siprToken != null) {
            $userHasSessionModel = SiprUserHasSession::select()
                ->where("session", "=", $siprToken)
                ->first();

            if ($userHasSessionModel != null) {
                $sessionExpiredAt = $userHasSessionModel->getExpiredAtMillis();
            }
        }

        $currentLongMillis = Carbon::now()->valueOf();

        if ($userHasSessionModel != null && $sessionExpiredAt < $currentLongMillis) {
            $userHasSessionModel->forceDelete();
            return redirect()->action([AccountManagementController::class, "formLogin"])->cookie("X-SIPR-TOKEN", "", -3600);
        }

        if ($userHasSessionModel != null && $sessionExpiredAt > $currentLongMillis) {
            return $next($request);
        } else {
            return redirect()->action([AccountManagementController::class, "formLogin"])->cookie("X-SIPR-TOKEN", "", -3600);
        }
    }
}
