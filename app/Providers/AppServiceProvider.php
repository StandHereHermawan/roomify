<?php

namespace App\Providers;

use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use App\Domains\User\Repository\Contracts\SiprPhoneNumberContactRepository;
use App\Domains\User\Repository\Contracts\SiprUserRepository;
use App\Domains\User\Repository\SiprEmailRepositoryImp;
use App\Domains\User\Repository\SiprPhoneNumberContactRepositoryImp;
use App\Domains\User\Repository\SiprUserRepositoryImp;
use App\Domains\User\Service\Contracts\SiprEmailService;
use App\Domains\User\Service\Contracts\SiprPhoneNumberContactService;
use App\Domains\User\Service\Contracts\SiprUserService;
use App\Domains\User\Service\SiprEmailServiceImp;
use App\Domains\User\Service\SiprPhoneNumberContactServiceImp;
use App\Domains\User\Service\SiprUserServiceImp;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        SiprUserRepository::class => SiprUserRepositoryImp::class,
        SiprUserService::class => SiprUserServiceImp::class,
        SiprEmailRepository::class => SiprEmailRepositoryImp::class,
        SiprEmailService::class => SiprEmailServiceImp::class,
        SiprPhoneNumberContactRepository::class => SiprPhoneNumberContactRepositoryImp::class,
        SiprPhoneNumberContactService::class => SiprPhoneNumberContactServiceImp::class,
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
