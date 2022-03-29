<?php

namespace Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use Domains\Authentication\Dtos\UserDto;

class CreateUserAction
{
    public static function run(UserDto $userDto): User
    {
        $user = User::create($userDto->toArray());

        return $user;
    }
}
