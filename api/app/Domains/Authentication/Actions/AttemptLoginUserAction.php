<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Exceptions\UserActionException;

class AttemptLoginUserAction
{
    /**
     * Attempt login based on email and password provided,
     *
     * @param  string $email
     * @param  string $password
     *
     * @return bool
     * @throws UserActionException ::invalidLoginCredentials
     */
    public static function run(string $email, string $password): bool
    {
        $pass =  auth()->guard()->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$pass) {
            throw UserActionException::invalidLoginCredentials();
        }

        return true;
    }
}
