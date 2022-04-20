<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\SendResetPasswordEmailAction;
use App\Infrastructure\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __construct(
        protected SendResetPasswordEmailAction $sendResetPasswordEmailAction
    ) {
        $this->middleware(['throttle:3,10']);
    }

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'email' => 'required|email',
        ]);

        $this->sendResetPasswordEmailAction->run($validated['email']);

        return $this->successResponse(
            data: null,
            message: 'Reset link sent to email!',
            code: 200
        );
    }
}
