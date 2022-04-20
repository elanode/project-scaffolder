<?php

namespace App\Domains\Shared\Authentication;

use App\Domains\Authentication\Actions\GetUserAction;
use App\Domains\Shared\Authentication\Actions\GetUserActionInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SharedAuthenticationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(GetUserActionInterface::class, GetUserAction::class);
    }

    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            GetUserActionInterface::class,
        ];
    }
}
