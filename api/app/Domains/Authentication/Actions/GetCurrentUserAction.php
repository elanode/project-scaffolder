<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use Illuminate\Http\Request;

class GetCurrentUserAction
{
    /**
     * Get authenticated user from request instance
     *
     * @param  Request $request
     *
     * @return User|null
     */
    public function run(Request $request): ?User
    {
        $user = $request->user();
        if (!$user) {
            return null;
        }

        // load relationships

        return $user;
    }
}
