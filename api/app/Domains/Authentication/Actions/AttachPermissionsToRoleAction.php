<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\Role;

class AttachPermissionsToRoleAction
{
    public function run(int $roleId, array $permissionsId): Role
    {
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($permissionsId);

        $role->load('permissions');

        return $role;
    }
}
