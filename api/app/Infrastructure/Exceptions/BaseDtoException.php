<?php

namespace App\Infrastructure\Exceptions;

use Exception;

abstract class BaseDtoException extends Exception
{
    protected static $dtoName = '[dto name not defined]';

    public static function missingAttribute(string $attribute): static
    {
        $dtoName = self::$dtoName;
        return new static("Missing required attribute when creating $dtoName dto [$attribute]", 500);
    }
}
