<?php

namespace App\Http\Middleware;

use Closure;

class CheckTermsOfServiceAgreement
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

        if(auth()->user()->accepted_terms_of_service === null) {
            $path = $request->path();

            return redirect('/terms-of-service')->with('path', $path);
        }

        return $next($request);
    }
}
