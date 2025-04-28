<?php

namespace App\Providers;

use App\Domains\User\Repository\Contracts\SiprUserRepository;
use App\Domains\User\Repository\Contracts\SiprEmailRepository;
use App\Domains\User\Repository\Contracts\SiprPhoneNumberRepository;
use App\Domains\User\Repository\Contracts\SiprRoleRepository;

use App\Domains\User\Repository\Contracts\SiprUserHasEmailRepository;
use App\Domains\User\Repository\Contracts\SiprUserHasPhoneNumberRepository;
use App\Domains\User\Repository\Contracts\SiprUserHasRoleRepository;
use App\Domains\User\Repository\Contracts\SiprUserHasSessionRepository;
use App\Domains\User\Repository\SiprUserRepositoryImp;
use App\Domains\User\Repository\SiprEmailRepositoryImp;
use App\Domains\User\Repository\SiprPhoneNumberRepositoryImp;
use App\Domains\User\Repository\SiprRoleRepositoryImp;

use App\Domains\User\Repository\SiprUserHasEmailRepositoryImp;
use App\Domains\User\Repository\SiprUserHasPhoneNumberRepositoryImp;
use App\Domains\User\Repository\SiprUserHasRoleRepositoryImp;
use App\Domains\User\Repository\SiprUserHasSessionRepositoryImp;
use App\Domains\User\Service\Contracts\SiprAccountService;
use App\Domains\User\Service\Contracts\SiprEmailService;
use App\Domains\User\Service\Contracts\SiprPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprRoleService;
use App\Domains\User\Service\Contracts\SiprUserHasEmailService;
use App\Domains\User\Service\Contracts\SiprUserHasPhoneNumberService;
use App\Domains\User\Service\Contracts\SiprUserHasRoleService;

use App\Domains\User\Service\Contracts\SiprUserHasSessionService;
use App\Domains\User\Service\Contracts\SiprUserService;

use App\Domains\User\Service\SiprAccountServiceImp;
use App\Domains\User\Service\SiprEmailServiceImp;
use App\Domains\User\Service\SiprPhoneNumberServiceImp;
use App\Domains\User\Service\SiprRoleServiceImp;
use App\Domains\User\Service\SiprUserHasEmailServiceImp;
use App\Domains\User\Service\SiprUserHasPhoneNumberServiceImp;
use App\Domains\User\Service\SiprUserHasRoleServiceImp;

use App\Domains\User\Service\SiprUserHasSessionServiceImp;
use App\Domains\User\Service\SiprUserServiceImp;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
            // Repository bindings
        SiprUserRepository::class => SiprUserRepositoryImp::class,
        SiprEmailRepository::class => SiprEmailRepositoryImp::class,
        SiprPhoneNumberRepository::class => SiprPhoneNumberRepositoryImp::class,
        SiprRoleRepository::class => SiprRoleRepositoryImp::class,
        SiprUserHasEmailRepository::class => SiprUserHasEmailRepositoryImp::class,
        SiprUserHasPhoneNumberRepository::class => SiprUserHasPhoneNumberRepositoryImp::class,
        SiprUserHasRoleRepository::class => SiprUserHasRoleRepositoryImp::class,
        SiprUserHasSessionRepository::class => SiprUserHasSessionRepositoryImp::class,

            // Service bindings with Repository Dependent
        SiprUserService::class => SiprUserServiceImp::class,
        SiprEmailService::class => SiprEmailServiceImp::class,
        SiprPhoneNumberService::class => SiprPhoneNumberServiceImp::class,
        SiprRoleService::class => SiprRoleServiceImp::class,
        SiprUserHasEmailService::class => SiprUserHasEmailServiceImp::class,
        SiprUserHasPhoneNumberService::class => SiprUserHasPhoneNumberServiceImp::class,
        SiprUserHasRoleService::class => SiprUserHasRoleServiceImp::class,
        SiprUserHasSessionService::class => SiprUserHasSessionServiceImp::class,

            // Service without Repository Dependent
        SiprAccountService::class => SiprAccountServiceImp::class
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
