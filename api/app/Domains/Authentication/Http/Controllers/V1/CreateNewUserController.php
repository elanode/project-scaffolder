<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\CreateUserAction;
use App\Domains\Authentication\Factories\UserDataFactory;
use App\Domains\Authentication\Http\Requests\UserFormRequest;
use App\Domains\Authentication\Http\Resources\UserResource;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateNewUserController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction
    ) {
        $this->middleware('permission:authentication create new user');
    }

    public function __invoke(UserFormRequest $request): JsonResponse
    {
        $userDto = UserDataFactory::fromRequest($request);
        $newUser = $this->createUserAction->run($userDto);

        return $this->successResponse(
            data: new UserResource($newUser),
            message: 'User created successfully',
            code: 201
        );
    }
}
