<?php

namespace App\Http\Controllers\Auth;
use App\CompanyLogo;
use Crypt;
use App\User;
use App\UserRole;
use App\UserDocument;
use App\UserLocale;
use App\MaintenanceLocale;
use App\BraintreeCustomer;
use Braintree;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm()
    {

        return view('auth.register');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'UserName' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'terms' => 'accepted',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $isActive = 0;
        $rolesId = $data['roleID'];
        if ($rolesId == 1) {
            $isActive = 1;
        }
        
        $users = User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'username' => $data['UserName'],
            'rolesId' => $data['roleID'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'isActive' => $isActive,
        ]);

        $braintree = BraintreeCustomer::create([
            'user_id' => $users->id
        ]);

        $gateway = new Braintree\Gateway([
        'environment' => env('BRAINTREE_ENV'),
        'merchantId' => env('BRAINTREE_MERCHANT_ID'),
        'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
        'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);

        $result = $gateway->customer()->create([
        'id' => $users->id,
        'firstName' => $users->firstName,
        'lastName' => $users->lastName,
        'email' => $users->email
        ]);

        return $users;

    }
}
