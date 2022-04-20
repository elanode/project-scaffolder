<?php

namespace App\Domains\Authentication\Exceptions;

use App\Infrastructure\Exceptions\BaseCustomException;

class AuthenticationDomainException extends BaseCustomException
{
    public static function cannotTerminateSuperAdmin(): self
    {
        return new static('Cannot terminate superadmin', 422);
    }

    public static function emailNotFound(): self
    {
        return new static('Email not found when trying to send reset email', 404);
    }
}
