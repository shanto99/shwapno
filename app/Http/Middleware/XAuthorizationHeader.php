<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XAuthorizationHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
        public function handle($request, Closure $next) {

        // check if we have an X-Authorization header present
        if($auth = $request->header('X-Authorization')) {
            $request->headers->set('Authorization', $auth);
        }

        return $next($request);
    }
}
