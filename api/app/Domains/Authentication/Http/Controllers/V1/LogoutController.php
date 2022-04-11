<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\LogoutUserAction;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(
        protected LogoutUserAction $logoutUserAction
    ) {
    }
    public function __invoke(Request $request): JsonResponse
    {
        $this->logoutUserAction->run($request->user());

        return $this->successResponse(
            data: '',
            message: 'Logged out successfully',
            code: 200
        );
    }
}
