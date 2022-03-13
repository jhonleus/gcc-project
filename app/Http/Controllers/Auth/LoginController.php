<?php

namespace App\Http\Controllers\Auth;
use App\CompanyLogo;
use Auth;
use App\UserDetail;
use App\UserLocale;
use App\MaintenanceLocale;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function showLoginForm()
    {

        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }

        return view('auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo;
    protected function redirectTo()
    {
        $users = UserDetail::where('usersId', Auth::user()->id)->get();
        $count = $users->count();

        /**
         *  0 = Admin
         *  1 = Applicant
         *  2 = Employer
         *  3 = Organization
         *  4 = School
         */

        switch(Auth::user()->rolesId){
            case 0:
                $this->redirectTo = '/admin';
                return $this->redirectTo;
                break;
            case 1:

                if($count > 0) {
                    $this->redirectTo = '/applicant';
                }
        
                $this->redirectTo = '/applicant/personal/'.Auth::user()->id.'/edit';

                return $this->redirectTo;
                break;
            case 2:
                $this->redirectTo = '/employer';
                return $this->redirectTo;
                break;
            case 3:
                $this->redirectTo = '/organization';
                return $this->redirectTo;
                break;
            case 4:
                $this->redirectTo = '/school';
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
            }
    }

    protected $username;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }
 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }
}
