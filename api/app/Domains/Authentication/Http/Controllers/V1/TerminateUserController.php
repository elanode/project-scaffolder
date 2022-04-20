<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\TerminateUserAction;
use App\Domains\Authentication\Http\Requests\TerminateUserRequest;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TerminateUserController extends Controller
{
    public function __construct(
        protected TerminateUserAction $terminateUserAction
    ) {
        $this->middleware('permission:authentication terminate any user');
    }

    public function __invoke(TerminateUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->terminateUserAction->run($validated['user_ids']);

        return $this->successResponse(
            data: [],
            message: 'Users terminated',
            code: 200
        );
    }
}
