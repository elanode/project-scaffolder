<?php

namespace App\Domains\Authentication\Dtos;

use App\Domains\Authentication\Exceptions\PermissionDtoException;

class PermissionDto
{
    public function __construct(
        public readonly string $name,
        public readonly null|array $assignToRoleIds = null
    ) {
        if (!empty($this->assignToRoleIds)) {
            foreach ($assignToRoleIds as $roleId) {
                if (!is_numeric($roleId)) {
                    throw PermissionDtoException::roleIdMustNumeric();
                }
            }
        }
    }
}
