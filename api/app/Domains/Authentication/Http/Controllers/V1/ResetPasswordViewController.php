<?php

namespace App\Domains\Authentication\Http\Controllers\V1;

use App\Infrastructure\Http\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordViewController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('auth.reset-password', ['token' => $request->token]);
    }
}
