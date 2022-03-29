<?php

namespace App\Domains\Authentication\Exceptions;

use Exception;

class UserActionException extends Exception
{
    public static function invalidLoginCredentials(): static
    {
        return new static("Invalid login credentials", 422);
    }
}
