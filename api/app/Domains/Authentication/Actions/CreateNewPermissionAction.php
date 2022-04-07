<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Dtos\PermissionDto;
use App\Domains\Authentication\Models\Permission;

class CreateNewPermissionAction
{
    public function run(PermissionDto $permissionDto): Permission
    {
        $permission = Permission::create([
            'name' => $permissionDto->name
        ]);

        if ($permissionDto->assignToRoleIds) {
            $permission->syncRoles($permissionDto->assignToRoleIds);
        }

        return $permission;
    }
}
