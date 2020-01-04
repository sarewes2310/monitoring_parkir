<?php

namespace App\Http\Middleware\MyAuth;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check()) {
            
            if(Auth::guard('api')->check()) {
                
            }else if(Auth::guard('web')->check()) {
                return route('login');    
            }
        }


        return $next($request);
    }
}
