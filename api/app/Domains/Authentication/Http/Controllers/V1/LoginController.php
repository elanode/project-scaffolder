<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\AttemptLoginUserAction;
use App\Domains\Authentication\Http\Requests\LoginUserRequest;
use App\Infrastructure\Http\Controller;
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
