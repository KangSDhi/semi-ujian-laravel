<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('get.login');
        // dd($request->getRequestUri());
        if ($request->expectsJson()) {
            return null;
        } else {
            if (str_contains($request->getRequestUri(), "/api")) {
                return route('get.error.401');
            }else{
                return route('get.login');
            }
        }
    }
}
