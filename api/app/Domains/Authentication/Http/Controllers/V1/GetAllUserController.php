<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\GetAllUserAction;
use App\Domains\Authentication\Http\Requests\GetAllUserRequest;
use App\Domains\Authentication\Http\Resources\UserResource;
use App\Infrastructure\Http\Controller;
use App\Support\Actions\Enums\SortDirectionEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAllUserController extends Controller
{
    public function __construct(
        protected GetAllUserAction $getAllUserAction
    ) {
        $this->middleware('permission:authentication get all user');
    }

    public function __invoke(GetAllUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $users = $this->getAllUserAction->run(
            withs: ['roles'],
            orderColumn: $validated['order_colum'] ?? 'created_at',
            sortDirection: SortDirectionEnum::tryFrom($validated['sort_direction'] ?? 'desc')
        );

        return $this->successResponse(
            data: UserResource::collection($users),
            requestClass: $request,
            pagination: true
        );
    }
}
