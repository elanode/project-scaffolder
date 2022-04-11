<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use App\Domains\Authentication\Dtos\UserDto;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function run(UserDto $userDto): User
    {
        $data = $userDto->toArray();

        if ($userDto->password) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = User::create($data);

        return $user;
    }
}
