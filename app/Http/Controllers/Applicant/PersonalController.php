<?php

namespace App\Http\Controllers\Applicant;

use DB;
use Auth;
use App\CompanyLogo;
use App\ExtraGender;
use App\ExtraCivil;
use App\ExtraHobby;
use App\ExtraCurrency;
use App\ExtraSpecialization;
use App\ExtraReligion;
use App\User;
use App\ExtraCountry;
use App\UserContact;
use App\MaintenanceResult;
use App\UserPrelocation;
use App\UserHobby;
use App\UserAddress;
use App\UserDetail;
use App\UserPreSpecialization;
use App\UserLocale;
use App\MaintenanceLocale;
use App\MaintenanceType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonalController extends Controller
{
    public function index() {   
        $usersId = Auth::user()->id;
    	$user    = User::where('id', $usersId)->with('details', 'address', 'contacts')->first();
    	$hobbies 	     = UserHobby::where('usersId', $usersId)->get();
    	$locations       = UserPrelocation::where('usersId', $usersId)->get();
    	$specializations = UserPreSpecialization::where('usersId', $usersId)->get();

    	return view('applicant.profile.personal', compact('specializations', 'user', 'hobbies', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $specializations = ExtraSpecialization::orderBy('name')->get();
        $genders = ExtraGender::orderBy('name')->get();
        $civils = ExtraCivil::orderBy('name')->get();
        $religions = ExtraReligion::orderBy('name')->get();
        $countries = ExtraCountry::orderBy('iso')->get();
        $hobbies = ExtraHobby::orderBy('name')->get();
        $currencies = ExtraCurrency::orderBy('name')->get();
        $results = MaintenanceResult::orderBy('name')->get();

        $array = User::where('id', $id)->with('hobbies')->get();
        $arrayloc = User::where('id', $id)->with('location')->get();
        $arrayspe = User::where('id', $id)->with('specialization')->get();
        $types = MaintenanceType::where("roleId", Auth::user()->rolesId)->get();

        $hobbiesTags = array();
        foreach($array as $val) {

            foreach($val->hobbies as $vals) {

                $a = $vals->hobbyId;
                array_push($hobbiesTags, $a);
            }
        }

        $locationTags = array();
        foreach($arrayloc as $val) {

            foreach($val->location as $vals) {

                $a = $vals->countryId;
                array_push($locationTags, $a);
            }
        }

        $specializationTags = array();
        foreach($arrayspe as $val) {

            foreach($val->specialization as $vals) {

                $a = $vals->specializationId;
                array_push($specializationTags, $a);
            }
        }
 
        $users = User::where('id', $id)->with('details', 'address', 'contacts')->first();
        return view('applicant.profile.personal_edit', compact('specializationTags', 'specializations', 'locationTags', 'hobbiesTags', 'users', 'genders', 'civils', 'religions', 'countries', 'hobbies', 'currencies', 'types', 'results')); 
    }

    public function update(Request $request, $id) {
        $usersId    = Auth::user()->id;
        $usersEmail = Auth::user()->email;
        $type_visa  = $request->input('type_visa');

        //dd($request->input('hobbies'));

        if($type_visa==14) {
            $attributes = request()->validate([
                'firstname'     => 'required|max:255',
                'lastname'      => 'required|max:255',
                'username'      => 'required|max:255|unique:users,username,'.$usersId,
                'birthdate'     => 'required|before:'.date("Y-m-d H:i:s", time()),
                'gender'        => 'required|exists:extra_genders,id',
                'civil'         => 'required|exists:extra_civils,id',
                'religion'      => 'required|exists:extra_religions,id',
                'currency'      => 'nullable|exists:extra_currencies,id',
                'numbers'       => 'nullable|digits_between:1,11|numeric',
                'type_visa'     => 'required|exists:maintenance_type,id',
                'result'        => 'required|exists:maintenance_result,id',
                'country'       => 'required|exists:extra_countries,id',
                'city'          => 'required|max:255',
                'street'        => 'required|max:255',
                'zip'           => 'required|digits_between:1,11|numeric',
                'hobbies'       => 'nullable|array|exists:extra_hobbies,id',
                'location'      => 'nullable|array|exists:extra_countries,id',
                'specialization'    => 'nullable|array|exists:extra_specializations,id',
            ]);
        }
        else {
            $attributes = request()->validate([
                'firstname'     => 'required|max:255',
                'lastname'      => 'required|max:255',
                'username'      => 'required|max:255|unique:users,username,'.$usersId,
                'birthdate'     => 'required|before:'.date("Y-m-d H:i:s", time()),
                'gender'        => 'required|exists:extra_genders,id',
                'civil'         => 'required|exists:extra_civils,id',
                'religion'      => 'required|exists:extra_religions,id',
                'currency'      => 'nullable|exists:extra_currencies,id',
                'numbers'       => 'nullable|digits_between:1,11|numeric',
                'type_visa'     => 'required|exists:maintenance_type,id',
                'result'        => 'nullable|exists:maintenance_result,id',
                'country'       => 'required|exists:extra_countries,id',
                'city'          => 'required|max:255',
                'street'        => 'required|max:255',
                'zip'           => 'required|digits_between:1,11|numeric',
                'hobbies'       => 'nullable|array|exists:extra_hobbies,id',
                'location'      => 'nullable|array|exists:extra_countries,id',
                'specialization'    => 'nullable|array|exists:extra_specializations,id',
            ]);
        }

        DB::beginTransaction();
        try {
            $users = User::find($usersId);

            $completeProfile = true;

            $users->firstName = $request->input('firstname');
            $users->lastName = $request->input('lastname');
            $users->email = $request->input('email');
            $users->username = $request->input('username');
            $users->save();

            $contacts = UserContact::firstOrNew(array('usersId' => $users->id));
            $contacts->usersId = $users->id;
            $contacts->codeId = $request->input('countycode');
            $contacts->number = $request->input('number');
            $contacts->save();
    
            $details = UserDetail::firstOrNew(array('usersId' => $users->id));
            $details->usersId = $users->id;
            $details->age = $request->input('age');
            $details->birthDate = $request->input('birthdate');
            $details->genderId = $request->input('gender');
            $details->civilId = $request->input('civil');
            $details->religionId = $request->input('religion');
            $details->currencyId = $request->input('currency');
            $details->number = $request->input('numbers');
            $details->typeId = $type_visa;
            if($type_visa==14) {
                $details->result = $request->input('result');
            }
            else {
                $details->result = null;
            }
            $details->isComplete = $completeProfile;
            $details->save();

            $hobbiess = $request->input('hobbies');
            $delete_hobbies = UserHobby::where('usersId', $users->id);
            $delete_hobbies->delete();
            if ($hobbiess) {
                foreach($hobbiess as $hobby) {
                    $hobbies = new UserHobby();
                    $hobbies->usersId = $users->id;
                    $hobbies->hobbyId = $hobby;
                    $hobbies->save();
                }
            }

            $locationss = $request->input('location');
            $delete_location = UserPrelocation::where('usersId', $users->id);
            $delete_location->delete();
            
            if ($locationss) {
                foreach($locationss as $location) {
                    $locations = new UserPrelocation();
                    $locations->usersId = $users->id;
                    $locations->countryId = $location;
                    $locations->save();
                }
            }

            $specializationss = $request->input('specialization');
            $delete_specialization = UserPreSpecialization::where('usersId', $users->id);
            $delete_specialization->delete();
            
            if ($specializationss) {
                foreach($specializationss as $specialization) {
                    $specializations = new UserPreSpecialization();
                    $specializations->usersId = $users->id;
                    $specializations->specializationId = $specialization;
                    $specializations->save();
                }
            }
    
            $address = UserAddress::firstOrNew(array('usersId' => $users->id));
            $address->usersId = $users->id;
            $address->countryId = $request->input('country');
            $address->city = $request->input('city');
            $address->street = $request->input('street');
            $address->zipcode = $request->input('zip');
            $address->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        alert()->success(MaintenanceLocale::getLocale(258), '');
        return redirect('applicant/personal');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
