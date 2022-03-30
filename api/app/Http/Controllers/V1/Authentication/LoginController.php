<?php

namespace App\Http\Controllers\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Domains\Authentication\Actions\AttemptLoginUserAction;
use App\Domains\Authentication\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class LoginController extends Controller
{
    public function __construct(protected AttemptLoginUserAction $attemptLoginUserAction)
    {
    }

    public function __invoke(LoginUserRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $this->attemptLoginUserAction->run(
                $request->get('email'),
                $request->get('password')
            );
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->intended();
    }
}
