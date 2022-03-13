<?php

namespace App\Http\Controllers\Auth;
use App\CompanyLogo;
use Crypt;
use App\User;
use App\UserDetail;
use App\UserAddress;
use App\UserRole;
use App\UserDocument;
use App\UserLocale;
use App\MaintenanceLocale;
use App\ExtraSpecialization;
use App\UserPreSpecialization;
use App\ExtraCountry;
use App\ExtraGender;
use App\UserCertification;
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
        $specializations = ExtraSpecialization::orderBy('name')->get();
        $genders = ExtraGender::orderBy('name')->get();
        $countries = ExtraCountry::orderBy('iso')->get();
        
        return view('auth.register', compact('specializations', 'genders', 'countries'));
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

        $userId = $users->id;

        if($data['roleID'] == 1 || $data['roleID'] === "1") {

            $detail = new UserDetail();
            $detail->usersId = $userId;
            $detail->birthDate = $data['birthdate'];
            $detail->genderId = $data['gender'];
            $detail->save();

            $address = new UserAddress();
            $address->usersId = $userId;
            $address->countryId = $data['country'];
            $address->save();

            if (isset($data['specialization']) && strlen($data['specialization']) > 0) { 
                $specializations = $data['specialization'];
                if ($specializations) {
                    foreach($specializations as $specialization) {
                        $spec = new UserPreSpecialization();
                        $spec->usersId = $userId;
                        $spec->specializationId = $specialization;
                        $spec->save();
                    }
                }
            }
            
            if (isset($data['ceritificates']) && strlen($data['ceritificates']) > 0) { 
                $ceritificates = $data['ceritificates'];
                if ($ceritificates) {
                    foreach($ceritificates as $ceritificate) {
                        $certi = new UserCertification();
                        $certi->usersId = $userId;
                        $certi->type = $ceritificate;
                        $certi->number = "0";
                        $certi->accreditor = "0";
                        $certi->date_issued = $data['birthdate'];
                        $certi->path = "0";
                        $certi->filename = "0";
                        $certi->save();
                    }
                }
            }
            
        }

        return $users;

    }
}
