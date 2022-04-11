<?php

namespace App\Domains\Authentication\Exceptions;

use App\Infrastructure\Exceptions\BaseDtoException;

class PermissionDtoException extends BaseDtoException
{
    protected static function getDtoName(): string
    {
        return 'Permission';
    }

    public static function roleIdMustNumeric(): static
    {
        return new static("All Role ID must be a numeric value", 422);
    }
}
