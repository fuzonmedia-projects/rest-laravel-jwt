<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //echo "<h1>jwt middlware<h1>";

        if(!Auth::check())
        return response()->json(['Message'=>'No access','status'=>401],403);
        else
        return $next($request);
    }
}
