<?php

namespace Domains\Authentication\Actions;

use Illuminate\Http\Request;

class AttemptLoginUserAction
{
    public static function run(string $email, string $password): bool
    {
        return auth()->guard()->attempt([
            'email' => $email,
            'password' => $password
        ]);
    }
}
