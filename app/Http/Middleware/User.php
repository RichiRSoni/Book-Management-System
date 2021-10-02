<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type == 'user') {
             return $next($request);
        } elseif (Auth::check() && Auth::user()->user_type == 'admin') {
            return $next($request);
        } else {
            return redirect('/login');
        }
        
    }
}

