<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReadCookiePassportMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (request()->is("oauth/token")) {
            if ($request->hasCookie('refresh_token')) {
                $token = $request->cookie('refresh_token');
                $request->request->add(['refresh_token' => $token]);
            }
        }
        return $next($request);
    }
}
