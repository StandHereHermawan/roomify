<?php

namespace App\Providers;

use App\Handler\CustomSessionHandler;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [

    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::defaultView('vendor.custom.bootstrap-5-custom');

        DB::listen(function (QueryExecuted $queryExecuted) {
            Log::debug("", ["sql" => $queryExecuted->sql, "binding_value" => $queryExecuted->bindings, "millisecond" => $queryExecuted->time,]);
        });

        Session::extend('database', function ($app) {
            return new CustomSessionHandler(
                DB::connection(),
                config('session.table', 'sessions'),
                config('session.lifetime', 120),
                $app
            );
        });
    }
}
