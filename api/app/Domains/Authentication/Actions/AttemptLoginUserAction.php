<?php

namespace App\Domains\Authentication\Actions;

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
