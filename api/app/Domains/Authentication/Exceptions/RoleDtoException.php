<?php

namespace App\Domains\Authentication\Exceptions;

use App\Infrastructure\Exceptions\BaseDtoException;

class RoleDtoException extends BaseDtoException
{
    protected static function getDtoName(): string
    {
        return 'Role';
    }
}
