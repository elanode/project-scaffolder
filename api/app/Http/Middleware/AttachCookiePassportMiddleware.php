<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachCookiePassportMiddleware
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
        $response = $next($request);

        if (request()->is("oauth/token")) {
            $json = json_decode($response->getContent(), false);
            $token = $json->refresh_token;
            if ($token) {
                return ($response)->cookie('refresh_token', $token, 15);
            }
        }
        return $response;
    }
}
