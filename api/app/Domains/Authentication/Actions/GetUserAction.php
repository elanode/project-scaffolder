<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use App\Domains\Shared\Authentication\Actions\GetUserActionInterface;

class GetUserAction implements GetUserActionInterface
{
    public function run(
        int $userId,
        array $withs = []
    ): User {
        $user = User::with($withs)->findOrFail($userId);

        return $user;
    }
}
