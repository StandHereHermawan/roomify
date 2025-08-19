<?php

namespace App\Http\Middleware\Custom;

use App\Traits\Logs\CustomLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AddContextRequestId
{
    use CustomLogger;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        /**
         *| UUID to request and context log. made every request to this website has a uuid representation.
         */
        $uuid = Str::uuid()->toString();

        /**
         *| Save UUID to request and context log. made every request to this website has a uuid representation.
         */
        $request->attributes->set('request_id', $uuid);
        $request->attributes->set('start_time', microtime(true));

        /**
         *| Simpan ke context log Laravel (bisa digunakan di Log::debug/info).
         *| Siapkan konteks log yang akan digunakan di semua log untuk request ini.
         */
        $logContext = [
            'request_id' => $uuid,
            'client_ip' => $request->ip(),
            'url' => $request->fullUrl(), /*| -- include query string -- |*/
            'client_ip_address' => $request->ip(),
            'http_method' => $request->method(),
            "timestamp" => Carbon::now(),
        ];

        /**
         *| Mulai sesi logging dengan konteks ini.
         */
        Log::withContext($logContext);

        $sanitizedContext = [
            'query_params' => $this->sanitizeParameters($request->query()),
            'body_params' => $this->sanitizeParameters($request->all()),
            'headers' => $this->sanitizeParameters($request->header()),
        ];

        /**
         *| Catat log "Start" dengan detail request.
         */
        $this->logInfoMessage(
            '[Incoming Request Start. request id: {request_id}.]',
            $sanitizedContext
        );

        /**
         *| Lanjutkan request ke controller.
         */
        $response = $next($request);

        /**
         *| Simpan response ke request agar bisa diakses di method terminate().
         */
        $request->attributes->set('response', $response);
        // $this->logDebugFinish(__FUNCTION__, $sanitizedContext);
        return $response;
    }

    /**
     *| Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        /**
         *| Konteks log dari method handle() masih aktif di sini.
         */

        /**
         *| ambil waktu mulai dari request.
         */
        $startTime = $request->attributes->get('start_time', microtime(true));

        /**
         *| Kalkulasi durasi dalam milidetik (ms).
         */
        $duration = round((microtime(true) - $startTime) * 1000, 2);


        /**
         *| Dapatkan penggunaan memori puncak dalam megabyte (MB).
         */
        $memory = round(memory_get_peak_usage(true) / 1024 / 1024, 2);

        $responseContext = [
            /* === ESSENSIAL INFORMATION === */
            'status_code' => $response->getStatusCode(),
            'duration' => "$duration milliseconds",

            /* === USEFUL INFORMATION === */
            'content_type' => $response->headers->get('content-type'),
            'memory_usage' => "$memory MegaByte",

            /* === INFORMASI OPSIONAL (MIGHT IMPACT PERFORMANCE, USE WITH CAUTIONS) === */
            // 'response_body' => $this->getSanitizedResponseData($response), // Uncomment jika benar-benar perlu, perhatikan performa
        ];

        /**
         *| Catat log "Finish" dengan detail response.
         */
        $this->logInfoMessage(
            '[Incoming Request Finish. duration {duration}. status: {status_code}. request id: {request_id}]',
            $responseContext
        );
    }

    /**
     *| Menyaring parameter untuk menyembunyikan data sensitif.
     */
    protected function sanitizeParameters(array $params): array
    {
        $sensitiveKeywords = [
            'password',
            'token',
            'secret',
            'key',
            'authorization',
            'credential'
        ];

        foreach ($params as $key => $value) {
            /**
             *| Jika key mengandung kata kunci sensitif, sembunyikan nilainya.
             */
            foreach ($sensitiveKeywords as $keyword) {
                if (stripos($key, $keyword) !== false) {
                    $params[$key] = '********';
                    continue 2; /*| -- Lanjut ke key berikutnya -- |*/
                }
            }
        }

        return $params;
    }
}
