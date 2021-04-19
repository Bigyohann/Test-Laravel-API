<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {

            if (!in_array($role, $request->user()->roles)){
                return response(['message'=> "You can't access to this ressource"], 403);
            }

        return $next($request);
    }
}
