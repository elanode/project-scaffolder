<?php

namespace App\Domains\Authentication\Exceptions;

use App\Infrastructure\Exceptions\BaseActionException;

class UserActionException extends BaseActionException
{
    public static function invalidLoginCredentials(): static
    {
        return new static("Invalid login credentials", 422);
    }
}
