<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserActive
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
        

    	if (!Auth::check()) {
    	    return redirect('/login');
    	}

    	if (Auth::user()->rolesId == 0) {
	        if(Auth::user()->isActive == 1) {
	        	return $next($request);
	    	} else {
    	    	return redirect('/requirement');
	    	}
    	}

    	if (Auth::user()->rolesId == 1) {
	        if(Auth::user()->isActive == 1) {
	        	return $next($request);
	    	} else {
    	    	return redirect('/requirement');
	    	}
    	}

    	if (Auth::user()->rolesId == 2) {
    	    if(Auth::user()->isActive == 1) {
	        	return $next($request);
	    	} else {
    	    	return redirect('/requirement');
	    	}
    	}

    	if (Auth::user()->rolesId == 3) {
    	    if(Auth::user()->isActive == 1) {
	        	return $next($request);
	    	} else {
    	    	return redirect('/requirement');
	    	}
    	}
    	
    	if (Auth::user()->rolesId == 4) {
    	    if(Auth::user()->isActive == 1) {
	        	return $next($request);
	    	} else {
    	    	return redirect('/requirement');
	    	}
    	}

        if (Auth::user()->rolesId == 5) {
            if(Auth::user()->isActive == 1) {
                return $next($request);
            } else {
                return redirect('/requirement');
            }
        }

        if (Auth::user()->rolesId == 6) {
            if(Auth::user()->isActive == 1) {
                return $next($request);
            } else {
                return redirect('/requirement');
            }
        }
    }
}
