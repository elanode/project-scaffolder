<?php

namespace App\Domains\Authentication\Dtos;

use App\Domains\Authentication\Exceptions\RoleDtoException;

class RoleDto
{
    public function __construct(
        public string $name
    ) {
        if (empty($this->name)) {
            throw RoleDtoException::missingAttribute('name');
        }
    }
}
