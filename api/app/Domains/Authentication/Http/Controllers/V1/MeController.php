<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\GetCurrentUserAction;
use App\Domains\Authentication\Http\Resources\UserResource;
use App\Infrastructure\Http\Controller;
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
