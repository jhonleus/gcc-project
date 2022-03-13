<?php
	namespace App\Http\Controllers\School;

	use DB;
	use Auth;
	use File;
	use Alert;

	use App\User;
	use App\UserAddress;
	use App\UserCourses;
	use App\UserDocument;
	use App\SchoolDetail;
	use App\SchoolCourse;
	use App\ExtraCountry;
	use App\MaintenanceType;
	use App\SubscriptionDetails;
	use App\SubscriberOtc;
	use App\Http\Controllers\Controller;
    use Intervention\Image\ImageManagerStatic as Image;

	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;
	use Illuminate\Support\Facades\Validator;

	class SchoolController extends Controller {
    	public function index() {
			$usersId = Auth::user()->id;

			/*get scheduled applicant*/
			$students = UserCourses::where("companyId", $usersId)->whereNotNull("schedule_date")->get();

			/*count of pending applicant*/
			$pending_applicant = UserCourses::where("companyId", $usersId)->where("status", 1)->count();
			/*count of scheduled applicant*/
			$sched_applicant = UserCourses::where("companyId", $usersId)->where("status", 2)->count();
			/*count of rejected applicant*/
			$reject_applicant = UserCourses::where("companyId", $usersId)->where("status", 0)->count();

			/*count of active course*/
			$course_active  = SchoolCourse::where('usersId', $usersId)->where("isActive", 1)->where("isDeleted", 0)->count();
			/*count of closed course*/
			$closed_course  = SchoolCourse::where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 0)->count();
			/*count of deleted course*/
			$deleted_course = SchoolCourse::where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 1)->count();

			return view('school.index', compact('students', 'pending_applicant', 'sched_applicant', 'reject_applicant', 'course_active', 'closed_course', 'deleted_course'));
    	}

    	/*school profile page*/
	    public function profile() {
	    	/*user's id*/
	        $usersId = Auth::user()->id;

	        /* get school info */
	        $users = User::where('id', $usersId)->with('school')->first();

	        /* get school logo */
	        $image = UserDocument::where('usersId', $usersId)->where('filetype', 'profile')->first();

			$subscription = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->first();
			$otc = SubscriberOtc::where("usersId", $usersId)->first();

	        return view('school.profile.index', compact('otc', 'users', 'image', 'subscription'));
	    }

	   	/*school details page*/
	    public function show() {
	    	/*user's id*/
	        $usersId = Auth::user()->id;
	        
	        /* get users info */
	        $users = User::where('id', $usersId)->with('school', 'address')->first();

	        return view('school.profile.details', compact('users'));
	    }

	    /*change school profile picture to database*/
	    public function store(Request $request) {
	        DB::beginTransaction();
	        try {
		        $usersId = Auth::user()->id;
		       
		       /*IF FILE IS NOT EMPTY*/
		        if($request->hasfile('upload')) {
		            
		            /*GET THE FILE*/
		            $file 		= $request->file('upload');
		            /*GET FILE TYPE*/
		            $extension 	= $file->getClientOriginalExtension();
		        
		            /*check if user uploaded a profile or not if uploaded then replace the existing if not create profile picture*/
	                $parameters = array('usersId' => $usersId, 'filetype' => "profile");
	                $users = UserDocument::firstOrNew($parameters);

		            /*IF ALREADY EXIST*/
		            if ($users->exists) {
		            	/*DELETE OLD FILE*/
		                File::delete($users->path . "" . $users->filename);
		                /*PUT NEW FILE*/
		                //$file->move(public_path()."/".$users->path, 'employer.'.$extension);

		                $image_resize = Image::make($file->getRealPath());              
		                $image_resize->resize(350, 350);
		                $image_resize->save(public_path()."/".$users->path.'employer.'.$extension);
		                /*LOCATION OF THE UPLOADED FILE*/
		                $location = $users->path;
		            } 
		            /*IF NOT EXIST*/
		            else {
		            	/*LOCATION OF THE UPLOADED FILE*/
		                $location = $usersId . '/images/';
		                /*INSERT NEW FILE*/
		                //$file->move(public_path()."/".$location, 'employer.'.$extension);
		                $image_resize = Image::make($file->getRealPath());              
		                $image_resize->resize(350, 350);
		                $image_resize->save(public_path()."/".$location, 'employer.'.$extension);
		            }

		            $users->usersId 	= $usersId;
		            $users->path 		= $location;
		            $users->filename 	= 'employer.'.$extension;
		            $users->filetype 	= 'profile';
		            $users->save();

		            DB::commit();

		            return redirect('school/profile')->with('success', 'SUCCESSFULLY CHANGED IMAGE!');
		        }
	        } 

	        catch (\Exception $ex) {
	            DB::rollback();
	            return response()->json(['error' => $ex->getMessage()], 500);
	        }
	    }

	    /*edit details page*/
	    public function edit() {
	    	/*user's id*/
	        $usersId = Auth::user()->id;

	        /*get all country*/
	        $types        = MaintenanceType::orderBy('name')->where('roleId', Auth::user()->rolesId)->get();
	        $countries    = ExtraCountry::orderBy('nicename')->get();

	        /* get users info */
	        $users = User::where('id', $usersId)->with('school', 'address')->first();

	        return view('school.profile.details_edit', compact('users', 'countries', 'types'));
	    }

	   	/*UPDATE SCHOOL DETAILS TO DATABASE*/
	    public function update(Request $request, $id) {
	    	$attributes = request()->validate([
                'school'   	  => 'required|max:255',
                'type'        => 'required|exists:maintenance_type,id',
                'phone'       => 'required|max:255',
                'about'       => 'required',
                'mission'     => 'required',
                'philosophy'  => 'required',
                'whys'        => 'required',
                'country'     => 'required|exists:extra_countries,id',
                'city'        => 'required|max:255',
                'street'      => 'required|max:255',
                'zip'         => 'required|digits_between:1,11|numeric',
            ]);

	       	DB::beginTransaction();
	       	try {
       			/*user's id*/
       		    $usersId = Auth::user()->id;
	       	    $users = User::find($usersId);
	       	    $parameters = array('usersId' => $usersId);
	       		
	            /*CREATE OR UPDATE SCHOOL DETAILS*/
	       	    $school = SchoolDetail::firstOrNew($parameters);
	       	    $school->usersId 	= $usersId;
	       	    $school->school 	= $request->input('school');
	       	    $school->telephone 	= $request->input('phone');
	            $school->typeId     = $request->input('type');
	       	    $school->isComplete = true;
	       	    $school->isActive 	= 1;
	       	    
	       	    /*SCHOOL EMAIL ADDRESS*/
	       	    $email = '';
	            if($request->has('check_any')){
	                $email = $users->email;
	            } else {
	                $email = $request->input('email');
	            }

				$school->email 				= $email;
	       	    $school->about_us 			= $request->input('about');
	       	    $school->mission_vision 	= $request->input('mission');
	       	    $school->philosophy 		= $request->input('philosophy');
	       	    $school->why_choose 		= $request->input('whys');

	       	    $school->website 	= $request->input('website');
	       	    $school->facebook 	= $request->input('facebook');
	       	    $school->twitter 	= $request->input('twitter');

	       	    /*save to database*/
	       	    $school->save();

	       	    $address 			= UserAddress::firstOrNew($parameters);
	       	    $address->usersId 	= $usersId;
	       	    $address->countryId = $request->input('country');
	       	    $address->city 		= $request->input('city');
	       	    $address->street 	= $request->input('street');
	       	    $address->zipcode 	= $request->input('zip');
	       	    /*save to database*/
	       	    $address->save();

	       	    DB::commit();

	       	    alert()->success('SUCCESSFULLY UPDATED','');
	       	    return redirect('school/details/'.Auth::user()->id);
	       	} 

	       	catch (\Exception $ex) {
	       	    DB::rollback();
	       	    return response()->json(['error' => $ex->getMessage()], 500);
	       	}
	    }
	}
?>	