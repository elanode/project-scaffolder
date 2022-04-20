<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\GetAllUserAction;
use App\Domains\Authentication\Enums\RoleEnum;
use App\Domains\Authentication\Http\Requests\GetAllUserRequest;
use App\Domains\Authentication\Http\Resources\UserResource;
use App\Domains\Authentication\Models\User;
use App\Infrastructure\Http\Controller;
use App\Support\Actions\Enums\SortDirectionEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetAllUserController extends Controller
{
    public function __construct(
        protected GetAllUserAction $getAllUserAction
    ) {
        $this->middleware('permission:authentication get all user');
    }

    public function __invoke(GetAllUserRequest $request): JsonResponse
    {
        /** @var User */
        $user = Auth::user();
        $validated = $request->validated();

        $users = $this->getAllUserAction->run(
            withs: ['roles'],
            orderColumn: $validated['order_colum'] ?? 'created_at',
            sortDirection: SortDirectionEnum::tryFrom($validated['sort_direction'] ?? 'desc'),
            paginate: $validated['paginate'] ?? 50,
            notSuperadmin: in_array(RoleEnum::SUPERADMIN->value, $user->getRoleNames()->toArray())
        );

        return $this->successResponse(
            data: UserResource::collection($users),
            requestClass: $request,
            pagination: true
        );
    }
}
