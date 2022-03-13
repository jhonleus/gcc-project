<?php

    namespace App\Http\Controllers\Support;

    use DB;
    use Auth;
    use File;
    use Alert;

    use App\User;
    use App\UserAddress;
    use App\EmployerJob;
    use App\ExtraCountry;
    use App\UserDocument;
    use App\ExtraIndustry;
    use App\EmployerDetail;
    use App\UserApplication;
    use App\MaintenanceBlog;
    use App\MaintenanceType;
    use App\EmployerAgencies;
    use App\SubscriberRatings;
    use App\SubscriptionDetails;
    use App\SubscriberOtc;
    use App\Http\Controllers\Controller;
    use Intervention\Image\ImageManagerStatic as Image;

    use Illuminate\Http\Request;
    use Illuminate\Pagination\Paginator;
    use Illuminate\Support\Facades\Validator;

    class OrganizationController extends Controller {

        /*home page*/
        public function index() {
            $usersId = Auth::user()->id;

            /*get all applicant who scheduled for interview*/
            $applicants = UserApplication::where("companyId", $usersId)->whereNotNull("scheduled")->get();

            /*get applicants who applied to an active job*/
            $pending_applicant  = UserApplication::where("companyId", $usersId)->where("status", 1)->count();
            $sched_applicant    = UserApplication::where("companyId", $usersId)->where("status", 2)->count();
            $reject_applicant   = UserApplication::where("companyId", $usersId)->where("status", 0)->count();

            $job_active   = EmployerJob::where('usersId', $usersId)->where("isActive", 1)->where("isDeleted", 0)->count();
            $closed_job   = EmployerJob::where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 0)->count();
            $deleted_job  = EmployerJob::where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 1)->count();

            return view('support.index', compact('applicants', 'pending_applicant', 'sched_applicant', 'reject_applicant', 'job_active', 'closed_job', 'deleted_job'));
        }

        /*organization profile page*/
        public function profile() {
          	$usersId = Auth::user()->id;
            
            /* get user info */
            $users = User::where('id', $usersId)->with('employer')->first();

            /* get user logo */
            $image = UserDocument::where('usersId', $usersId)->where('filetype', 'profile')->first();
            
            $subscription = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->first();
            $otc = SubscriberOtc::where("usersId", $usersId)->first();

            return view('support.profile.index', compact('otc', 'users', 'image', 'subscription'));
        }

        public function store(Request $request) {
            DB::beginTransaction();
            try {
                /*user's id*/
                $usersId = Auth::user()->id;
             
                /*if image is not empty*/
                if($request->hasfile('upload')) {
                    /*get the file*/
                    $file = $request->file('upload');
                    /*get file type*/
                    $extension = $file->getClientOriginalExtension();

                    /*check if user uploaded a profile or not if uploaded then replace the existing if not create profile picture*/
                    $parameters = array('usersId'   => $usersId, 'filetype'  => "profile");
                    /*check if user already has a profile or not. if yes replace for new profile picture if no upload the profile picture*/
                    $users = UserDocument::firstOrNew($parameters);

                    /*if already exists*/
                    if ($users->exists) {
                        /*delete old file*/
                        File::delete($users->path . "" . $users->filename);
                        /*create new file*/
                        //$file->move(public_path()."/".$users->path, 'employer.'.$extension);

                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(350, 350);
                        $image_resize->save(public_path()."/".$users->path.'employer.'.$extension);
                        /*location of the uploaded file*/
                        $location = $users->path;
                    } 
                    /*if not exists*/
                    else {
                        /*location of the uploaded file*/
                        $location = $usersId . '/images/';
                        /*insert the profile*/
                        // /$file->move(public_path()."/".$location, 'employer.'.$extension);
                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(350, 350);
                        $image_resize->save(public_path()."/".$location, 'employer.'.$extension);
                    }

                    /*user's id*/
                    $users->usersId = $usersId;
                    /*location of the uploaded file*/
                    $users->path = $location;
                    /*filename*/
                    $users->filename = 'employer.'.$extension;
                    /*type of the image*/
                    $users->filetype = 'profile';
                    /*save to database*/
                    $users->save();

                    DB::commit();

                    return redirect('organization/profile')->with('success', 'SUCCESSFULLY CHANGED IMAGE!');
                }
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }

        /*ORGANIZATION DETAILS*/
        public function show($id) {
            /*user's id*/
            $usersId = Auth::user()->id;
            /* get users info */
            $users 	= User::where('id', $usersId)->with('employer', 'address')->first();

            return view('support.profile.details', compact('users'));
        }

        /*EDIT DETAILS*/
        public function edit($id) {
            /*user's id*/
            $usersId = Auth::user()->id;
            /*get list of countries*/
            $countries = ExtraCountry::orderBy('nicename')->get();
            /*get list of industry*/
            $industry  = ExtraIndustry::orderBy('name')->get();
            /*get list of organization types*/
            $types = MaintenanceType::orderBy('name')->where('roleId', Auth::user()->rolesId)->get();

            /* get users info */
            $users = User::where('id', $usersId)->with('employer', 'address')->first();

            return view('support.profile.details_edit', compact('countries', 'industry', 'users', 'types'));
        }

        /*update details to database*/
        public function update(Request $request, $id) {
            /*validate fields*/
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
                /*get users details*/
           	    $users = User::find($usersId);

                /*parameters to check if new or existing*/
                $employeParam = array('usersId' => $usersId);
                /*create or update users details*/
           	    $employer = EmployerDetail::firstOrNew($employeParam);
           	    $employer->usersId 	  = $usersId;
        		$employer->company 	  = $request->input('company');  
        		$employer->industryId = $request->input('industry');
                $employer->telephone  = $request->input('phone');
           	    $employer->isActive   = 1;
    			   
                $email = '';
                if($request->has('check_any')){
                    $email = $users->email;
                } 
                else {
                    $email = $request->input('email');
                }

                $employer->email 			  = $email;
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
           	
                /*create or update users address*/
           	    $address 			      = UserAddress::firstOrNew($employeParam);
           	    $address->usersId 	= $users->id;
           	    $address->countryId = $request->input('country');
           	    $address->city      = $request->input('city');
           	    $address->street 	  = $request->input('street');
           	    $address->zipcode 	= $request->input('zip');
                /*save to database*/
           	    $address->save();

           	    DB::commit();

                alert()->success('SUCCESSFULLY UPDATED','');
                return redirect('organization/details/'.$usersId);
           	} 

            catch (\Exception $ex) {
           	    DB::rollback();
           	    return response()->json(['error' => $ex->getMessage()], 500);
           	}
        }
    }
?>
