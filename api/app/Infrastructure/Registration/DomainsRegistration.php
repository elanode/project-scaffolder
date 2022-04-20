<?php

namespace App\Infrastructure\Registration;

use App\Domains\Authentication\AuthenticationDomainRegistration;

class DomainsRegistration
{
    /**
     * Register all domains here.
     *
     * @var array
     */
    protected static $registrationClasses = [
        AuthenticationDomainRegistration::class,
    ];

    public static function getAllRegisteredDomainsPolicy(): array
    {
        $results = [];
        foreach (self::$registrationClasses as $class) {
            $results = array_merge($results, $class::getPoliciesMap());
        }

        return $results;
    }

    public static function domainRoutesFilePath(): array
    {
        $routes = [];

        foreach (self::$registrationClasses as $class) {
            $routes = array_merge($routes, $class::getRouteFilePathsMap());
        }

        return $routes;
    }

    public static function usedSharedServiceProviders(): array
    {
        $results = [];
        foreach (self::$registrationClasses as $class) {
            $results = array_merge($results, $class::getSharedServiceProvidersNeeded());
        }

        return $results;
    }

    public static function getMigrationPaths(): array
    {
        $results = [];
        foreach (self::$registrationClasses as $class) {
            $results = array_merge($results, $class::getMigrationPaths());
        }

        return $results;
    }
}
