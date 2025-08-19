<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprSecondaryEmail;

use App\Policies\EmailPolicy;
use App\Policies\PhoneNumberPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        SiprSecondaryEmail::class => EmailPolicy::class,
        SiprPhoneNumber::class => PhoneNumberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
