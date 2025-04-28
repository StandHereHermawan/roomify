<?php

namespace App\Domains\User\Middleware;

use App\Domains\User\Controller\AccountManagementController;
use App\Domains\User\Model\SiprUserHasSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAlreadyLoginMiddleware
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

        if ($siprToken != null) {
            $userHasSessionModel = SiprUserHasSession::select()
                ->where("session", "=", $siprToken)
                ->first();
        }

        if ($siprToken == null) {
            return $next($request);
        } else {
            if ($userHasSessionModel == null) {
                return redirect()->action([AccountManagementController::class, "formLogin"]);
            } else {
                return response()->redirectToAction([AccountManagementController::class, "dashboard"]);
            }
        }
    }
}
