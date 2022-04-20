<?php

namespace App\Infrastructure\Http\Middleware;

use App\Domains\Authentication\Actions\LogoutUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotTerminatedUserMiddleware
{
    public function __construct(
        protected LogoutUserAction $logoutUserAction
    ) {
    }

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if ($request->user()->is_terminated && !$request->user()->hasRole(RoleEnum::SUPERADMIN->value)) {
                $this->logoutUserAction->run($request->user());

                throw new AuthorizationException("You are not authorized to access.", 403);
            }
        }

        return $next($request);
    }
}
