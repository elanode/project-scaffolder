<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\UpdateUserAction;
use App\Domains\Authentication\Factories\UserDataFactory;
use App\Domains\Authentication\Http\Requests\UserFormRequest;
use App\Domains\Authentication\Http\Resources\UserResource;
use App\Domains\Authentication\Models\User;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\Request;

class UpdateUserAccountController extends Controller
{
    public function __construct(
        protected UpdateUserAction $updateUserAction
    ) {
    }

    public function __invoke(UserFormRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user = $this->updateUserAction->run(
            $user->id,
            UserDataFactory::fromRequest($request)
        );

        return $this->successResponse(
            data: new UserResource($user),
            message: 'User account updated'
        );
    }
}
