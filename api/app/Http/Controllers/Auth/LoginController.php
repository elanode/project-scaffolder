<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (auth()->guard()->attempt($request->only('email', 'password'))) {
            return redirect()->intended();
        }

        return $this->errorResponse(
            'Something went wrong trying to log you in',
            500
        );
    }
}
