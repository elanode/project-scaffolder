<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\UpdateUserAction;
use App\Domains\Authentication\Factories\UserDataFactory;
use App\Domains\Authentication\Http\Requests\UserFormRequest;
use App\Domains\Authentication\Http\Resources\UserResource;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\Request;

class UpdateMyUserAccountController extends Controller
{
    public function __construct(
        protected UpdateUserAction $updateUserAction
    ) {
    }

    public function __invoke(UserFormRequest $request)
    {
        $this->authorize('update', auth()->user());

        $userDto = UserDataFactory::fromRequest($request);
        $user = $this->updateUserAction->run(auth()->id(), $userDto);

        return $this->successResponse(
            data: new UserResource($user),
            message: 'User account updated'
        );
    }
}
