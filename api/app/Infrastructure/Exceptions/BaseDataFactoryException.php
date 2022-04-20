<?php

namespace App\Infrastructure\Exceptions;

abstract class BaseDataFactoryException extends BaseCustomException
{
    public static function missingAttribute(string $field): static
    {
        return new static("Missing required field: [$field]", 422);
    }
}
