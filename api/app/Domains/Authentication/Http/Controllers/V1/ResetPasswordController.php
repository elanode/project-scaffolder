<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Domains\Authentication\Actions\ResetUserPasswordAction;
use App\Infrastructure\Http\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ResetPasswordController extends Controller
{
    public function __construct(
        protected ResetUserPasswordAction $resetUserPasswordAction
    ) {
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                RulesPassword::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        $status = $this->resetUserPasswordAction->run(
            $request->email,
            $request->password,
            $request->password_confirmation,
            $request->token
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : redirect()->back()->withErrors(['email' => [__($status)]]);
    }
}
