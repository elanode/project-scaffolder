<?php

namespace App\Domains\Authentication;

use App\Infrastructure\Registration\RegistrationInterface;

class AuthenticationDomainRegistration implements RegistrationInterface
{
    public static function getPoliciesMap(): array
    {
        return [
            'App\Domains\Authentication\Models\User' => 'App\Domains\Authentication\Policies\UserPolicy',
        ];
    }

    public static function getRouteFilePathsMap(): array
    {
        return [
            base_path('app/Domains/Authentication/Routes/authentication.php'),
        ];
    }

    public static function getSharedServiceProvidersNeeded(): array
    {
        return [];
    }

    public static function getMigrationPaths(): array
    {
        return [
            'app/Domains/Authentication/Database/Migrations',
        ];
    }
}
