<?php

namespace App\Domains\Authentication\Exceptions;

use App\Infrastructure\Exceptions\BaseDtoException;

class UserDtoException extends BaseDtoException
{
    protected static function getDtoName(): string
    {
        return 'User';
    }
}
