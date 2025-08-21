<?php

namespace App\Providers;

use App\Handler\CustomSessionHandler;
use App\Traits\Logs\CustomLogger;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use CustomLogger;

    public array $singletons = [];

    /**
     *| Register any application services.
     *|
     */
    public function register(): void
    {
        // $millis_start = $this->logDebugStart(__FUNCTION__, []);
        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
    }

    /**
     *| Bootstrap any application services.
     *|
     */
    public function boot(): void
    {
        // $millis_start = $this->logDebugStart(__FUNCTION__, []);

        Paginator::useBootstrapFive();
        Paginator::defaultView('vendor.custom.bootstrap-5-custom');

        DB::listen(function (QueryExecuted $queryExecuted) {
            $sqlLogContext = [
                "sql" => $queryExecuted->sql,
                "binding_value" => $queryExecuted->bindings,
                "millisecond" => $queryExecuted->time
            ];

            if (env('DB_LISTENER')) {
                # code...
                $this->logDebugMessage(
                    "Closure",
                    "query listener called",
                    $sqlLogContext
                );
            }
        });

        Session::extend('database', function ($app) {
            // $millis_start = $this->logDebugStart("Closure");

            
            // $this->logDebugFinish("Closure", [], $millis_start);
            return new CustomSessionHandler(
                DB::connection(),
                config('session.table', 'sessions'),
                config('session.lifetime', 120),
                $app
            );
        });
        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
    }
}
