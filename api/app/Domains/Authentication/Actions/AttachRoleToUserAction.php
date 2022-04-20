<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Models\Role;
use App\Domains\Authentication\Models\User;

class AttachRoleToUserAction
{
    /**
     * Undocumented function
     *
     * @param  int    $userId
     * @param  array|RoleEnum ...$roleEnums
     *
     * @return void
     */
    public function run(int $userId, ...$roleEnums): void
    {
        $user = User::findOrFail($userId);
        $roleNames = collect($roleEnums)
            ->flatten()
            ->map(fn (RoleEnum $roleEnum) => $roleEnum->value)
            ->toArray();

        $user->assignRole($roleNames);
    }
}
