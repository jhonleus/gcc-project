<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Student
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
            return redirect('/employer');
        }
        
        if (Auth::user()->rolesId == 3) {
            return redirect('/organization');
        }

        if (Auth::user()->rolesId == 4) {
            return redirect('/school');
        }

        if (Auth::user()->rolesId == 5) {
            return $next($request);
        }

        if (Auth::user()->rolesId == 6) {
            return redirect('/support');
        }
    }
}
