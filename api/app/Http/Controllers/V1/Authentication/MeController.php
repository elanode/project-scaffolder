<?php

namespace App\Http\Controllers\V1\Authentication;

use App\Domains\Authentication\Actions\GetCurrentUserAction;
use App\Domains\Authentication\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct(
        protected GetCurrentUserAction $getCurrentUserAction
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $this->getCurrentUserAction->run($request);

        return $this->successResponse(
            data: new UserResource($user)
        );
    }
}
