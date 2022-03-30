<?php

namespace App\Domains\Authentication\Factories;

use App\Domains\Authentication\Dtos\UserDto;
use App\Domains\Authentication\Requests\UserFormRequest;

class UserDataFactory
{
    public static function fromArray(
        array $array
    ): UserDto {
        $data = (object) $array;

        return new UserDto(
            name: $data->name,
            email: $data->email,
            password: $data->password
        );
    }

    public static function fromRequest(
        UserFormRequest $request
    ): UserDto {
        $validated = (object) $request->validated();

        return new UserDto(
            name: $validated->name,
            email: $validated->email,
            password: $validated->password ?? null
        );
    }
}
