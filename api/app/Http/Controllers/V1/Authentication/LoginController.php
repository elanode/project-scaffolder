<?php

namespace App\Http\Controllers\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Domains\Authentication\Actions\AttemptLoginUserAction;
use App\Domains\Authentication\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function __construct(protected AttemptLoginUserAction $attemptLoginUserAction)
    {
    }

    public function __invoke(LoginUserRequest $request): RedirectResponse|JsonResponse
    {
        if ($this->attemptLoginUserAction->run(
            $request->get('email'),
            $request->get('password')
        )) {
            return redirect()->intended();
        }

        return $this->errorResponse(
            'Something went wrong trying to log you in',
            500
        );
    }
}
