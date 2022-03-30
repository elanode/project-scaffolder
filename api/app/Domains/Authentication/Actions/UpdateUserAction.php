<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use App\Domains\Authentication\Dtos\UserDto;

class UpdateUserAction
{
    public function run(int $id, UserDto $userDto): User
    {
        $user = User::findOrFail($id);

        $user->fill($userDto->toArray());
        $user->save();

        return $user->fresh();
    }
}
