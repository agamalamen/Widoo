<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!Auth::User()) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route(app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName());
            }   
        return $next($request);
        } else {
            return redirect()->route('account.index');
        }

    }
}
