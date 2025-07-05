<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RequestUniqueIdentifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uuid = Str::uuid()->toString();

        // Simpan UUID ke request dan context log
        $request->attributes->set('request_uuid', $uuid);

        // Simpan ke context log Laravel (bisa digunakan di Log::debug/info)
        Log::withContext([
            'request_uuid' => $uuid,
            'client_ip_address' => $request->ip(),
            'url' => $request->url(),
            'http_method' => $request->method(),
            "timestamp" => Carbon::now(),
            // "log_level" => env('LOG_LEVEL', config('logging.channels.stderr.level', 'debug')),
        ]);

        return $next($request);
    }
}
