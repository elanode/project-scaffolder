<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\Role;
use App\Domains\Authentication\Models\User;

class AttachRoleToUserAction
{
    public function run(int $userId, RoleEnum ...$roleEnums): void
    {
        $user = User::findOrFail($userId);
        foreach ($roleEnums as $roleEnum) {
            $user->assignRole($roleEnum->value);
        }
    }
}
