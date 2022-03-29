<?php

namespace App\Http\Controllers\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Domains\Authentication\Actions\LogoutUserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        LogoutUserAction::run($request->user());

        return $this->successResponse(
            data: '',
            message: 'Logged out successfully',
            code: 200
        );
    }
}