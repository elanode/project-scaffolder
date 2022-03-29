<?php

namespace Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use Domains\Authentication\Dtos\UserDto;

class UpdateUserAction
{
    public static function run(int $id, UserDto $userDto): User
    {
        $user = User::findOrFail($id);

        $user->fill($userDto->toArray());
        $user->save();

        return $user->fresh();
    }
}
