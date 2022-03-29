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
     * @return User
     */
    public static function run(Request $request): User
    {
        $user = $request->user();

        // load relationships

        return $user;
    }
}
