<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use App\Domains\Authentication\Dtos\UserDto;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function run(int $id, UserDto $userDto): User
    {
        $user = User::findOrFail($id);
        $data = $userDto->toArray();

        if ($userDto->password) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data);
        $user->save();

        return $user->fresh();
    }
}
