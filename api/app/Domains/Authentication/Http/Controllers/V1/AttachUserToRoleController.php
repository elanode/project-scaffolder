<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\AttachRoleToUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Http\Requests\AttachUserToRoleRequest;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttachUserToRoleController extends Controller
{
    public function __construct(
        protected AttachRoleToUserAction $attachRoleToUserAction
    ) {
        $this->middleware('permission:authentication attach user to role');
    }

    public function __invoke(AttachUserToRoleRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $roleEnums = collect($validated['role_names'])
            ->map(fn ($roleName) => RoleEnum::tryFrom($roleName))
            ->toArray();

        $this->attachRoleToUserAction->run($validated['user_id'], $roleEnums);

        return $this->successResponse(
            data: [],
            message: 'User attached to role successfully',
            code: 200
        );
    }
}
