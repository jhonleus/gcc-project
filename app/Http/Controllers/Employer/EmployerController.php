<?php
	namespace App\Http\Controllers\Employer;

	use DB;
	use Auth;
	use File;
	use Carbon\Carbon;

	use App\User;
	use App\UserLocale;
	use App\EmployerJob;
	use App\CompanyLogo;
	use App\UserAddress;
	use App\UserDocument;
	use App\ExtraCountry;
	use App\ExtraIndustry;
	use App\EmployerDetail;
	use App\EmployerPayment;
	use App\UserApplication;
	use App\MaintenanceBlog;
	use App\MaintenanceType;
	use App\EmployerAgencies;
	use App\MaintenanceLocale;
	use App\SubscriptionDetails;
	use App\MaintenanceSubscriptions;
	use App\SubscriberOtc;
	use App\Http\Controllers\Controller;
  use Intervention\Image\ImageManagerStatic as Image;
	use Illuminate\Http\Request;
	use Illuminate\Pagination\Paginator;
	use Illuminate\Support\Facades\Validator;

	class EmployerController extends Controller {

		/*home page*/
    	public function index() {
    		$usersId = Auth::user()->id;

			/*get all applicant who scheduled for interview*/
			$applicants = UserApplication::where("companyId", $usersId)->whereNotNull("scheduled")->get();

			$pending_applicant  = UserApplication::where("companyId", $usersId)->where("status", 1)->count();
			$sched_applicant    = UserApplication::where("companyId", $usersId)->where("status", 2)->count();
			$reject_applicant   = UserApplication::where("companyId", $usersId)->where("status", 0)->count();

			$job_active   = EmployerJob::where('usersId', $usersId)->where("isActive", 1)->where("isDeleted", 0)->count();
			$closed_job   = EmployerJob::where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 0)->count();
			$deleted_job  = EmployerJob::where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 1)->count();

	    	return view('employer.index', compact('applicants', 'pending_applicant', 'sched_applicant', 'reject_applicant', 'job_active', 'closed_job', 'deleted_job'));
    	}

    	/*profile page*/
        public function profile() {
	    	/*user's id*/
          	$usersId = Auth::user()->id;
          	/*get date now*/
	    	$now = Carbon::now()->format('Y-m-d');

            /* get users info */
            $users = User::where('id', $usersId)->with('employer')->first();

            /* get user's logo */
            $image = UserDocument::where('usersId', $usersId)->where('filetype', 'profile')->first();

			$subscription = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->first();
			$otc = SubscriberOtc::where("usersId", $usersId)->first();

        	return view('employer.profile.index', compact('otc', 'users', 'image', 'subscription'));
        }

        /*user's details page*/
        public function show() {
	    	/*user's id*/
            $usersId = Auth::user()->id;
            
            /* get users info */
		    $users = User::where('id', $usersId)->with('employer', 'address')->first();
		
		    return view('employer.profile.details', compact('users'));
        }

        /*edit user's details page*/
        public function edit($id) {
	    	/*user's id*/
            $usersId 	= Auth::user()->id;
            /*list of country*/
    		$countries 	= ExtraCountry::orderBy('nicename')->get();
            /*list of industry*/
    		$industry 	= ExtraIndustry::orderBy('name')->get();
            /*types of company*/
            $types      = MaintenanceType::orderBy('name')->where('roleId', Auth::user()->rolesId)->get();

            /* get users info */
        	$users = User::where('id', $usersId)->with('employer', 'address')->first();

            return view('employer.profile.details_edit', compact('countries', 'industry', 'users', 'types'));
        }

        /*update details to database*/
        public function update(Request $request, $id) {
            $attributes = request()->validate([
                'company'     => 'required|max:255',
                'industry'    => 'required|exists:extra_industries,id',
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
                
                /*create or update users deta*/
           	    $employer 				= EmployerDetail::firstOrNew($parameters);
           	    $employer->usersId 		= $usersId;
          		  $employer->company 		= $request->input('company');
          		  $employer->industryId 	= $request->input('industry');
           	    $employer->telephone 	= $request->input('phone');
           	    $employer->isComplete 	= true;
           	    $employer->isActive 	= 1;
    			
                $email = '';
                if($request->has('check_any')){
                    $email = $users->email;
                } 
                else {
                    $email = $request->input('email');
                }

                $employer->email 			= $email;
           	    $employer->about_us 		= $request->input('about');
           	    $employer->mission_vision 	= $request->input('mission');
           	    $employer->philosophy 		= $request->input('philosophy');
           	    $employer->why_choose 		= $request->input('whys');

           	    $employer->website 	= $request->input('website');
           	    $employer->facebook = $request->input('facebook');
           	    $employer->twitter 	= $request->input('twitter');

           	    /*save to database*/
           	    $employer->save();

                $name = User::find($usersId);
                $name->firstName = $request->input('company');
                $name->save();
           	
           	    $address 	        = UserAddress::firstOrNew($parameters);
           	    $address->usersId 	= $usersId;
           	    $address->countryId = $request->input('country');
           	    $address->city      = $request->input('city');
           	    $address->street 	= $request->input('street');
           	    $address->zipcode 	= $request->input('zip');
           	    $address->save();

           	    DB::commit();

                alert()->success('SUCCESSFULLY UPDATED','');
                return redirect('employer/details/'.Auth::user()->id);
           	} 

            catch (\Exception $ex) {
           	    DB::rollback();
           	    return response()->json(['error' => $ex->getMessage()], 500);
           	}
        }

       	public function store(Request $request) {
           	DB::beginTransaction();
            try {
            	/*user's id*/
      	        $usersId = Auth::user()->id;
      	       
      	       	/*if file is not empty*/
      	        if($request->hasfile('upload')) {
      	            $file = $request->file('upload');
      	            /*get file type*/
      	            $extension = $file->getClientOriginalExtension();

      	            /*check if user uploaded a profile or not if uploaded then replace the existing if not create profile picture*/
      	            $parameters = array('usersId' => $usersId, 'filetype' => "profile");
      	            $users = UserDocument::firstOrNew($parameters);

      	            /*if already exist*/
      	            if ($users->exists) {
      	            	/*delete old file*/
      	                File::delete(public_path().$users->path . "" . $users->filename);
      	                /*create new file*/
      	                //$file->move(public_path()."/".$users->path, 'employer.'.$extension);

                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(350, 350);
                        $image_resize->save(public_path()."/".$users->path.'employer.'.$extension);

      	                /*location of the uploaded file*/
      	                $location = $users->path;
      	            } 
      	            /*if not exist*/
      	            else {
      	                /*location of the uploaded file*/
      	                $location = $usersId . '/images/';
      	                /*create new file*/

                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(350, 350);
                        $image_resize->save(public_path()."/".$location, 'employer.'.$extension);
      	                //$file->move(public_path()."/".$location, 'employer.'.$extension);
      	            }

      	            $users->usersId  = $usersId;
      	            $users->path     = $location;
      	            $users->filename = 'employer.'.$extension;
      	            $users->filetype = 'profile';
      	            /*save to database*/
      	            $users->save();

      	            DB::commit();

      	            return redirect('employer/profile')->with('success', 'SUCCESSFULLY CHANGED IMAGE!');
      	        }
            } 

            catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['error' => $ex->getMessage()], 500);
			}
        }
	}
?>