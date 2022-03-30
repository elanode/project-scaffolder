<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use App\Domains\Authentication\Dtos\UserDto;

class CreateUserAction
{
    public function run(UserDto $userDto): User
    {
        $user = User::create($userDto->toArray());

        return $user;
    }
}
