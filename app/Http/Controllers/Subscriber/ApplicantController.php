<?php

    namespace App\Http\Controllers\Subscriber;

    use DB;
    use Auth;
    use \Carbon\Carbon;

    use App\User;
    use App\EmailModel;
    use App\MaintenanceType;
    use App\EmployerJob;
    use App\UserDocument;
    use App\ExtraCountry;
    use App\ExtraCurrency;
    use App\UserInvitation;
    use App\ExtraEmployment;
    use App\EmployerBookmark;
    use App\UserCertification;
    use App\SubscriptionDetails;
    use App\ExtraSpecialization;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Validator;

    class ApplicantController extends Controller {

        /*list of applicants*/
        public function index() {
            /*user's id*/
            $usersId = Auth::user()->id;
            /*date today*/
            $now = Carbon::now()->format('Y-m-d');
            $search = false;

            $country 		= ExtraCountry::orderBy('nicename')->get();
            $specialization = ExtraSpecialization::orderBy('name')->get();
            $jobs           = EmployerJob::select('title', 'id')->where("usersId", $usersId)->get();
            $types          = MaintenanceType::where("roleId", 1)->orderBy('name')->get();

            $saves  = EmployerBookmark::where("usersId", $usersId)->get();
            $saves_ = array();


            foreach ($saves as $save) {
            	array_push($saves_, $save->applicantId);
            }


            if(Auth::user()->rolesId == 4) {

                $users = User::where("users.rolesId", 1)->where(function($q) {
                            $q->whereHas('details', function($r) {
                                $r->where('typeId', 9); 
                            });
                        })->paginate(10);

            }

            else {

                $users = User::with('details', 'address', 'contacts', 'documents', 'applications')->where("users.rolesId", 1)->orderBy('id', 'DESC')->paginate(10);

            }


    		return view('subscriber.applicants.index', compact('search', 'country', 'specialization', 'users', 'saves_', 'jobs', 'types'));
        }

        public function search() {
            /*user's id*/
            $usersId = Auth::user()->id;
            /*date today*/
            $now = Carbon::now()->format('Y-m-d');
            $search = true;

            $saves = EmployerBookmark::where("usersId", $usersId)->get();
            $saves_ = array();
            foreach ($saves as $save) {
                array_push($saves_, $save->applicantId);
            }

            if (isset($_POST['clear_filter'])) {

                $get_spe = "";
                $get_loc = "";
                $get_title = "";
                $get_level = "";
                $get_salary = "";

            }

            else {

               /*get filter inputs*/
               $get_spe    = Input::get('specialization');
               $get_loc    = Input::get('location');
               $get_title  = Input::get('title');
               $get_level  = Input::get('level');
               $get_salary = Input::get('salary'); 

            }

            if(Auth::user()->rolesId == 4) {

                $users = User::query()->where("users.rolesId", 1)->where(function($q) {
                            $q->whereHas('details', function($r) {
                                $r->where('typeId', 9); 
                            });
                        });

            }

            else {

                $users = User::query()->with('details', 'address', 'contacts', 'documents', 'specialization', 'location')->where("users.rolesId", 1);

            }

            if (!empty($get_spe)) {
                $users = $users->where(function($q) use($get_spe) {
                            $q->whereHas('specialization', function($r) use($get_spe) {
                                $r->where('specializationId', $get_spe); 
                            })->orWhereHas('applications', function($s) use($get_spe) {
                                $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('specializationId', $get_spe);
                            });
                        });
            }

            if (!empty($get_loc)) {
                $users = $users->where(function($q) use($get_loc) {
                            $q->WhereHas('address', function($s) use($get_loc) {
                                $s->where('countryId', $get_loc); 
                            });
                        });
            }

            if (!empty($get_level)) {
                $users = $users->where(function($q) use($get_level) {
                            $q->whereHas('levels', function($r) use($get_level) {
                                $r->where('type', $get_level); 
                            });
                        });
            }

            if (!empty($get_salary)) {
                $users = $users->where(function($q) use($get_salary) {
                            $q->whereHas('details', function($r) use($get_salary) {
                                $r->where('number', "<=", $get_salary)->where('number', ">=", $get_salary);
                            })->orWhereHas('applications', function($s) use($get_salary) {
                                $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('min', '<=', $get_salary)->where('max', ">=", $get_salary);
                            });
                        });
            }

            if (!empty($get_title)) {
                $users =    $users->where(function($q) use($get_title) {
                                $q->whereHas('details', function($r) use($get_title) {
                                     $r->join('maintenance_type', "user_details.typeId", '=', "maintenance_type.id")->where('maintenance_type.id', $get_title);
                                });
                            });
            }

            $users = $users->paginate(10);

            $country        = ExtraCountry::orderBy('nicename')->get();
            $specialization = ExtraSpecialization::orderBy('name')->get();
            $jobs           = EmployerJob::select('title', 'id')->where("usersId", $usersId)->get();
            $types          = MaintenanceType::where("roleId", 1)->orderBy('name')->get();

            return view('subscriber.applicants.index', compact('search', 'get_salary', 'get_spe', 'get_loc', 'get_title', 'get_level', 'users', 'specialization', 'country', 'saves_', 'jobs', 'types'));
        }

        public function show($applicantId) {
            $usersId = Auth::user()->id;
            $now = Carbon::now()->format('Y-m-d');

            $canViewProfile = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $usersId)->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->where("ms.check_profile", 1)->orderBy('subscriber_details.id', 'DESC')->count();

            if($canViewProfile > 0) {
                /*get applicant details*/
                $user = User::where("id", $applicantId)->first();

                /*get applicant certificates*/
                $certificates = UserCertification::where("usersId", $applicantId)->where(function ($query) {
                      $query->where('type', "N1")->orWhere("type","N2")->orWhere("type","N3")->orWhere("type","N4")->orWhere("type","N5");
                })->orderBy('id', 'desc')->paginate(10);

                /*get applicant tattoos*/
                $tattoos = UserDocument::where('usersId', $applicantId)->where('filetype', 'tattoo')->paginate(10);

                return view('subscriber.applicants.profile', compact('user', 'certificates', 'tattoos'));
            }
            else {
                alert()->error("Your subscription has no View Applicant's Profile feature, please upgrade your subscription to unlock this feature.");
                return redirect('pricing');
            }
        }

        public function store(Request $request) {
            DB::beginTransaction();
            try {    
                $id 			= Auth::user()->id;
                $applicantId 	= $request->input('id');
                $rowSaved       = $request->input('rowSaved');

                $user = EmployerBookmark::where('applicantId', $applicantId)
                		->where("usersId", $id)->first();

                if ($user === null) {
                   	$applicant 				= new EmployerBookmark();
                   	$applicant->applicantId	= $applicantId;
                   	$applicant->usersId		= $id;
                   	$result_msg 			= "SUCCESSFULLY SAVED";
                	$applicant->save();
                }
                else {
                	EmployerBookmark::where("id", $user->id)->delete();
                	$result_msg = "SUCCESSFULLY UNSAVED";
                }

                /*save to database*/
                DB::commit();

                return response()->json(['result' => true, "message" => $result_msg, "applicantId" => $rowSaved]);
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()]);            
            }
        }

        /*schedule the student for enrollment*/
        public function send_invitation(Request $request) {
            DB::beginTransaction();
            try {
                /*validate all inputs*/
                $validator = Validator::make($request->all(), [
                    'job_id'          => 'required|exists:employer_jobs,id',
                    'applicant_id'    => 'required|exists:users,id',
                    'applicant_name'  => 'required|max:255',
                    'applicant_email' => 'required|max:255',
                    'subject'         => 'required|max:255',
                    'message'         => 'required',
                    'date'            => 'required|after:'.date("Y-m-d H:i:s", time()),
                ]);

                /*if validator fails*/
                if ($validator->fails()) {
                    return response()->json(array(
                        'result'    => false,
                        'message'   => $validator->getMessageBag()->toArray()
                    ));
                }
                /*if validates successful*/ 
                else {

                    $jobId      = $request->input("job_id");
                    $date       = $request->input("date");
                    $usersId    = $request->input("applicant_id");
                    $companyId  = Auth::user()->id;
                    /*subject of the email*/
                    $subject = $request->input("subject");
                    /*message or body of the email*/
                    $message = $request->input("message");

                    $invite             = new UserInvitation();
                    $invite->jobId      = $jobId;
                    $invite->usersId    = $usersId;
                    $invite->companyId  = $companyId;
                    $invite->subject    = $subject;
                    $invite->message    = $message;
                    $invite->scheduled  = $date;
                    $invite->status     = 1;
                    $invite->save();

                    $receiver_name  = $request->input("applicant_name");
                    $receiver_email = $request->input("applicant_email");
                    $actions        = "";

                    /*parameters for sending email*/
                    $emailArray = array("receiver_email" => $receiver_email, "receiver_name" => $receiver_name,"message" => $message, "actions" => $actions, "subject"  => $subject);

                    /*send the email*/
                    EmailModel::sendEmail($emailArray);

                    DB::commit();

                    $result_msg = "SUCCESSFULLY INVITED";
                    return response()->json(['result'=>true, "message"=> $result_msg]);
                }
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, "message" => $ex->getMessage()]);
            }
        }

        public function matched($job_id) {
            $usersId = Auth::user()->id;
            /*date today*/
            $now = Carbon::now()->format('Y-m-d');

            $saves  = EmployerBookmark::where("usersId", $usersId)->get();
            $saves_ = array();
            foreach ($saves as $save) {
                array_push($saves_, $save->applicantId);
            }

            $jobs = EmployerJob::where("usersId", $usersId)->where('isActive', 1)->where('isDeleted', 0)->where('isValidate', 1)->where('last_day', ">", $now)->where('id', $job_id)->first();

            $users = array();

            $get_spe        = $jobs->specializationId;
            $get_loc        = $jobs->locationId;
            $get_cur        = $jobs->currencyId;
            $get_salary     = $jobs->min;
            $get_title      = $jobs->title;

            $users = User::query()->with('details', 'address', 'contacts', 'documents', 'specialization', 'location')->where("users.rolesId", 1)
                    ->where(function($q) use($get_spe, $usersId) {
                        $q->whereHas('specialization', function($r) use($get_spe, $usersId) {
                            $r->where('specializationId', $get_spe); 
                        })->orWhereHas('applications', function($s) use($get_spe, $usersId) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('specializationId', $get_spe)->where('employer_jobs.usersId', '!=', $usersId);
                        });
                    })
                    ->where(function($q) use($get_loc, $usersId) {
                        $q->whereHas('location', function($r) use($get_loc, $usersId) {
                            $r->where('countryId', $get_loc); 
                        })->orWhereHas('address', function($s) use($get_loc, $usersId) {
                            $s->where('countryId', $get_loc); 
                        })->orWhereHas('applications', function($s) use($get_loc, $usersId) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('locationId', $get_loc)->where('employer_jobs.usersId', '!=', $usersId); 
                        });
                    })
                    ->where(function($q) use($get_cur, $usersId) {
                        $q->whereHas('details', function($r) use($get_cur, $usersId) {
                            $r->where('currencyId', $get_cur); 
                        })->orWhereHas('applications', function($s) use($get_cur, $usersId) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('currencyId', $get_cur)->where('employer_jobs.usersId', '!=', $usersId);
                        });
                    })
                    ->where(function($q) use($get_salary, $usersId) {
                        $q->whereHas('details', function($r) use($get_salary, $usersId) {
                            $r->where('number', "<=", $get_salary)->where('number', ">=", $get_salary);
                        })->orWhereHas('applications', function($s) use($get_salary, $usersId) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('min', '<=', $get_salary)->where('max', ">=", $get_salary)->where('employer_jobs.usersId', '!=', $usersId);
                        });
                    })
                    ->where(function($q) use($get_title, $usersId) {
                        $q->whereHas('works', function($r) use($get_title, $usersId) {
                            $r->where('position', 'like', '%'.$get_title.'%'); 
                        })->orWhereHas('applications', function($s) use($get_title, $usersId) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('title', 'like', '%'.$get_title.'%')->where('employer_jobs.usersId', '!=', $usersId);
                        });
                    })->paginate(10);

                
            return view('subscriber.applicants.matched', compact('users', 'jobs', 'saves_'));
        }
    }
?>
