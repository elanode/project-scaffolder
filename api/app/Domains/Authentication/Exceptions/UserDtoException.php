<?php

namespace App\Domains\Authentication\Exceptions;

use Exception;

class UserDtoException extends Exception
{
    public static function missingAttribute(string $attribute): static
    {
        return new static("Missing required attribute when creating user dto [$attribute]", 500);
    }
}
