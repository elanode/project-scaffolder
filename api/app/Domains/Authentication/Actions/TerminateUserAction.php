<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Exceptions\AuthenticationDomainException;
use App\Domains\Authentication\Models\User;
use Illuminate\Support\Facades\DB;

class TerminateUserAction
{
    public function run(array $userIds)
    {
        $users = User::findMany($userIds);
        DB::transaction(function () use ($users) {
            foreach ($users as $user) {
                if ($user->hasRole(RoleEnum::SUPERADMIN->value)) {
                    throw AuthenticationDomainException::cannotTerminateSuperAdmin();
                }

                $user->is_terminated = true;
                $user->save();
            }
        });
    }
}
