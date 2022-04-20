<?php

namespace App\Infrastructure\Providers;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Infrastructure\Registration\DomainsRegistration;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->policies = DomainsRegistration::getAllRegisteredDomainsPolicy();

        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole(RoleEnum::SUPERADMIN->value) ? true : null;
        });

        if (!$this->app->routesAreCached()) {
            Passport::routes(null, ['middleware' => 'passport']);
            // Passport::routes();
        }
        Passport::tokensExpireIn(now()->addMinutes(5));
        Passport::refreshTokensExpireIn(now()->addMinutes(15));
        //
    }
}
