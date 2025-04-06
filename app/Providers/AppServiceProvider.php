<?php

namespace App\Providers;

use App\Repository\Contracts\SiprUserRepository;
use App\Repository\SiprUserRepositoryImp;
use App\Service\Contracts\SiprUserService;
use App\Service\SiprUserServiceImp;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        SiprUserRepository::class => SiprUserRepositoryImp::class,
        SiprUserService::class => SiprUserServiceImp::class
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
        DB::listen(function (QueryExecuted $queryExecuted) {
            Log::debug($queryExecuted->sql);
        });
    }
}
