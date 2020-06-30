<?php

namespace App\Http\Middleware;

use Closure;

class UserChangedPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->check() && auth()->user()->passwordNeedsReset()) {
            return redirect()->route('password.request')->with('status', 'You need to reset your password');
        }

        return $next($request);
    }
}
