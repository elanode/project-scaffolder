<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domains\Authentication\Actions\LogoutUserAction;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        LogoutUserAction::run($request->user());

        return $this->successResponse(
            data: '',
            message: 'Logged out successfully',
            code: 200
        );
    }
}
