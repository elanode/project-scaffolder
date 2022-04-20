<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Exceptions\AuthenticationDomainException;
use App\Domains\Authentication\Models\User;
use Illuminate\Support\Facades\Password;

class SendResetPasswordEmailAction
{
    public function run(string $email): string|array
    {
        $status = Password::sendResetLink(["email" => $email]);

        return $status === Password::PASSWORD_RESET
            ?  __($status)
            : [__($status)];
    }
}
