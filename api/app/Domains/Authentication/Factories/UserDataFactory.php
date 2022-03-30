<?php

namespace App\Domains\Authentication\Factories;

use App\Domains\Authentication\Dtos\UserDto;
use App\Domains\Authentication\Requests\UserRequest;

class UserDataFactory
{
    public static function fromArray(
        array $array
    ): UserDto {
        $collect = collect($array);

        return new UserDto(
            name: $collect->name,
            email: $collect->email,
            password: $collect->password
        );
    }

    public static function fromRequest(
        UserRequest $request
    ): UserDto {
        $validated = collect($request->validated());

        return new UserDto(
            name: $validated->name,
            email: $validated->email,
            password: $validated->password ?? null
        );
    }
}
