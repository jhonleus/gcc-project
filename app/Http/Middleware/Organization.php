<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Organization
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
        /**
         *  0 = Admin
         *  1 = Applicant
         *  2 = Employer
         *  3 = Organization
         *  4 = School
         */

        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->rolesId == 0) {
            return redirect('/admin');
        }
        if (Auth::user()->rolesId == 1) {
            return redirect('/applicant');
        }
        if (Auth::user()->rolesId == 2) {
            if(Auth::user()->isActive != 1) {
            	return redirect('/requirement');
        	} else {
            	return redirect('/employer');
        	}
        }
        if (Auth::user()->rolesId == 3) {
        	if(Auth::user()->isActive != 1) {
            	return redirect('/requirement');
        	} else {
            	return $next($request);
        	}
        }
        if (Auth::user()->rolesId == 4) {
        	if(Auth::user()->isActive != 1) {
            	return redirect('/requirement');
        	} else {
            	return redirect('/school');
        	}
        }

        if (Auth::user()->rolesId == 5) {
            return redirect('/student');
        }

        if (Auth::user()->rolesId == 6) {
            if(Auth::user()->isActive != 1) {
                return redirect('/requirement');
            } else {
                return redirect('/support');
            }
        }
    }
}
