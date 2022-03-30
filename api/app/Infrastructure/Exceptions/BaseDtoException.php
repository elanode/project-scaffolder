<?php

namespace App\Infrastructure\Exceptions;

use Exception;

abstract class BaseDtoException extends Exception
{
    public static function missingAttribute(string $attribute): static
    {
        $dtoName = static::getDtoName();
        return new static("Missing required attribute when creating [$dtoName] dto, attribute: [$attribute]", 500);
    }

    protected abstract static function getDtoName(): string;
}
