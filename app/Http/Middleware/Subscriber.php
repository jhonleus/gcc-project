<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Subscriber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
       	if (!Auth::check()) {
       	    return redirect('/login');
       	}
       	
       	if (Auth::user()->rolesId == 0) {
       	    return redirect('/admin');
       	}
       
       	if (Auth::user()->rolesId == 1) {
       	    return redirect('/applicant');
       	}
       
       	if (Auth::user()->rolesId == 2 || Auth::user()->rolesId == 3 || Auth::user()->rolesId == 4 || Auth::user()->rolesId == 6) {
       	    return $next($request);
       	}
    }
}
