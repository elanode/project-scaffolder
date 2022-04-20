<?php

namespace App\Infrastructure\Registration;

interface RegistrationInterface
{
    /**
     * The default mapping of policy classes between model and policy class 
     *
     * @return array
     */
    public static function getPoliciesMap(): array;

    /**
     * The route paths
     * 
     * e.g. base_path('app/Domains/Authentication/Routes/whateverroute.php')
     *
     * @return array
     */
    public static function getRouteFilePathsMap(): array;

    /**
     * The service providers needed for calling across domains
     * 
     * e.g. App\Domains\Shared\Authentication\Actions\SharedAuthenticationServiceProvider::class
     * 
     * @return array
     */
    public static function getSharedServiceProvidersNeeded(): array;

    /**
     * The migration path of the domain
     * 
     * e.g. 'app/Domains/Authentication/Database/Migrations'
     * 
     * @return array
     */
    public static function getMigrationPaths(): array;
}
