<?php
	namespace App\Http\Controllers\Employer;

	use DB;
	use Auth;
	use Redirect;
	use \Carbon\Carbon;

	use App\User;
	use App\UserWork;
	use App\EmailModel;
	use App\EmployerJob;
	use App\ExtraCountry;
	use App\UserDocument;
	use App\ExtraCurrency;
	use App\UserEducation;
	use App\EmployerDetail;
	use App\UserInvitation;
	use App\UserApplication;
	use App\UserJobsResponse;
	use App\MaintenanceEmail;
	use App\EmployerBookmark;
	use App\UserCertification;
	use App\ExtraSpecialization;
	use App\SubscriptionDetails;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Validator;

	class ApplicantController extends Controller {

		/*list of applications of applicants*/
	    public function index() {
	    	/*user's id*/
			$usersId = Auth::user()->id;

			/*get pending applicant's application on active course*/
			$users = UserApplication::with('applicant', 'details', 'address', 'contacts', 'application', 'documents')->where('companyId', $usersId)->where('status', '1')->orderBy('id', 'desc')->paginate(10);

			/*get approved applicant's application on active course*/
			$approves = UserApplication::with('applicant', 'details', 'address', 'contacts', 'application', 'documents')->where('companyId', $usersId)->where('status', '2')->whereNull("scheduled")->orderBy('id', 'desc')->paginate(10);

			/*get scheduled applicant's application on active course*/
			$schedules = UserApplication::with('applicant', 'details', 'address', 'contacts', 'application', 'documents')->where('companyId', $usersId)->where('status', '2')->whereNotNull("scheduled")->orderBy('id', 'desc')->paginate(10);

			/*get rejected applicant's application on active course*/
			$rejects 		= UserApplication::with('applicant', 'details', 'address', 'contacts', 'application', 'documents')->where('companyId', $usersId)->where('status', '3')->orderBy('id', 'desc')->paginate(10);

	        return view('employer.applicants.index', compact('users', 'approves', 'schedules', 'rejects'));
		}

		/*applicant details by id*/
		public function show($id) {
	        /*user's id*/
			$usersId = Auth::user()->id;

	        /*get applicant application details*/
	        $user = UserApplication::with('applicant', 'details', 'address', 'contacts', 'application', 'documents')->where('id', $id)->first();

			return view('employer.applicants.information', compact('user'));
	    }

	    /*list of saved applicant*/
	    public function saved() {
	        /*user's id*/
	      	$usersId = Auth::user()->id;

			$users = EmployerBookmark::with('applicant', 'details', 'address', 'contacts', 'documents')->where('usersId', $usersId)->paginate(10);
            $jobs = EmployerJob::select('title', 'id')->where("usersId", $usersId)->get();
            
			return view('employer.applicants.bookmark', compact('users', 'jobs'));
	    }

	    /*schedule the student for enrollment*/
	   	public function approve(Request $request) {
	 		DB::beginTransaction();
	 		try {
		        /*validate all inputs*/
		        $validator = Validator::make($request->all(), [
		            'job_name'        => 'required|max:255',
		            'applicant_name'  => 'required|max:255',
		            'applicant_email' => 'required|max:255',
		            'application_id'  => 'required|exists:user_applications,id',
		            'asubject'        => 'required|max:255',
		            'amessage'        => 'required',
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
		            /*application id of the applicant*/
		       		$id = $request->input('application_id');
		            /*schedule date of the applicant this is applicable for sending email features*/
		       		$date = $request->input('date');

		       		/*update the status of the application into scheduled or approve*/
		     		$job = UserApplication::find($id);
		            /*2 means scheduled or approve applicant*/
		 		    $job->status 	= 2;
		 		    $job->isActive 	= 1;
		 		    $job->scheduled = $date;

		 		    /*scheduled date given by school*/
		 		    $scheduled = date('F d, Y', strtotime($date));
		 		   
		 		    $hour 	= date("H",strtotime($date));
		 		    $minute = date("i",strtotime($date));
		 		    
		 		    if($hour > 12) {
		 		        $hours = $hour - 12;
		 		    }
		 		    else {
		 		        $hours = $hour;
		 		    }
		 		    if($hour > 11) {
		 		        $period = 'PM';
		 		    }
		 		    else {
		 		        $period = 'AM';
		 		    }

		 		    /*scheduled time given by school*/
		 		    $schedule_time = $hours . ":" . $minute . " " . $period;
					
		  			/*applicant's info*/
		  			$receiver_email = $request->input('applicant_email'); /*email address*/
		  			$receiver_name 	= $request->input('applicant_name');	/*name*/
		  			$job_name = $request->input('job_name');	/*job title*/

		            /*subject of the email*/
		      		$subject = $request->input("asubject");
		            /*message or body of the email*/
		      		$message = $request->input("amessage");

		            /*put the job that user applied for into the temp subject*/
		      		$subject = str_replace("[application_name]",$job_name,$subject);
		      		/*put the schedule date into the template message*/
		      		$message = str_replace("[application_date]",$scheduled,$message);

		  			/*put the schedule time into the template message*/
		  			$message = str_replace("[application_time]",$schedule_time,$message);

		  			/*put the job that the users applied for into the temp message*/
		  			$message = str_replace("[application_name]",$job_name,$message);

		  			$job->message = $message;
		            /*save to database*/
		     		$job->save();

		            /*get response of the applicant applicable to can send email features*/
		     		$parameters = array("jobApplicationId" => $job->id);

		            /*check if has a response or no response yet*/
		  			$response = UserJobsResponse::firstOrNew($parameters);
		  			$response->usersId = $job->usersId;
		  			$response->jobApplicationId = $job->id;
		            /*3 means scheduled*/
		      		$response->isAccept = 3;
		            /*save to database*/
		      		$response->save();

		      		$actions = "Please check your profile <a href='".url('applicant/jobs/'.$job->id)."'>here</a> to response.";

		      			/*parameters for sending email*/
		      		$emailArray = array("receiver_email" => $receiver_email, "receiver_name" => $receiver_name,"message" => $message, "actions"	=> $actions, "subject" 	=> $subject);

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

	    public function reject(Request $request) {
	     	DB::beginTransaction();
	     	try {
	            /*validate all inputs*/
	            $validator = Validator::make($request->all(), [
	                'job_name'        => 'required|max:255',
	                'applicant_name'  => 'required|max:255',
	                'applicant_email' => 'required|max:255',
	                'application_id'  => 'required|exists:user_applications,id',
	                'dsubject'        => 'required|max:255',
	                'dmessage'        => 'required',
	            ]);

	            if ($validator->fails()) {
	                return response()->json(array(
	                    'result'    => false,
	                    'message'   => $validator->getMessageBag()->toArray()
	                ));
	            }
	            else {
	                /*get application ID*/
	                $application_id = $request->input('application_id');
	         			  /*change the application of the user into rejected*/
	         		$application = UserApplication::find($application_id);
	                /*3 means rejected*/
	     		    $application->status 	= 3;
	     		    $application->isActive 	= 1;
	     		    $application->save();

	     		    /*applicant's info*/
	      			$receiver_email = $request->input('applicant_email'); //email
	      			$receiver_name 	= $request->input('applicant_name');	//name
	      			$job_name 	    = $request->input('job_name');	//name

	      			$subject 	= $request->input("dsubject");
	      			$message 	= $request->input("dmessage");

	      			/*put the job name that the users applied for into the template message*/
	      			$subject  	= str_replace("[application_name]",$job_name,$subject);
	      			$message  	= str_replace("[application_name]",$job_name,$message);
	      			$actions = "Please check your profile <a href='".url('applicant/jobs/'.$application->usersId)."'>here</a> for details.";

	      			/*parameters for sending email*/
	      			$emailArray = array("receiver_email" 	=> $receiver_email, "receiver_name" 	=> $receiver_name, "message"	=> $message, "actions"	=> $actions, "subject" 	=> $subject);
	      			
	      			/*send the email*/
	      			EmailModel::sendEmail($emailArray);

	     		    DB::commit();

	     		    $result_msg = "SUCCESSFULLY REJECTED";
	         		return response()->json(['result'=>true, "message"=> $result_msg]);
	            }
	     	} 

	 		catch (\Exception $ex) {
	 		    DB::rollback();
	 		    return response()->json(['result' => false, "message" => $ex->getMessage()]);
	 		}
	    }

	    /*schedule the student for enrollment*/
	   	public function approve2(Request $request) {
	     	DB::beginTransaction();
	     	try {
	            /*validate all inputs*/
	            $validator = Validator::make($request->all(), [
	                'job_name'        => 'required|max:255',
	                'applicant_name'  => 'required|max:255',
	                'applicant_email' => 'required|max:255',
	                'application_id'  => 'required|exists:user_applications,id'
	            ]);

	            if ($validator->fails()) {
	                return response()->json(array(
	                    'result'    => false,
	                    'message'   => $validator->getMessageBag()->toArray()
	                ));
	            }
	            else {
	                /*get applicant id*/
	                $applicantId     = $request->input('application_id');
	                $date            = $request->input('date');

	                /*update the status of the application into scheduled or approve*/
	                $application              = UserApplication::find($applicantId);
	                /*2 means approve*/
	                $application->status      = 2;
	                $application->isActive    = 1;
	                /*scheduled date this is applicable for user's who have a email notification to applicant features*/
	                $application->scheduled   = $date;
	                /*save to database*/
	                $application->save();

	                /*applicants info*/
	                $job_name       = $request->input('job_name');  /*job title*/
	                $receiver_email = $request->input('applicant_email'); /*email_address*/
	                $receiver_name  = $request->input('applicant_name');  /*name*/

	                /*get email templates for approved applicant*/
	                $approveEmail = MaintenanceEmail::find(1);

	                /*get email's subject*/
	                $subject = $approveEmail->subject;
	                /*put the job name on the subject of the email*/
	                $subject = str_replace("[application_name]", $job_name, $subject);

	                /*get email's message/body*/
	                $message = $approveEmail->message;
	                /*put the job name on the message or body of the email*/
	                $message = str_replace("[application_name]", $job_name, $message);

	                $actions = "Please check your profile <a href='".url('applicant/jobs/'.$application->usersId)."'>here</a> for details.";

	                /*parameters for sending email*/
	                $emailArray = array("receiver_email"  => $receiver_email, "receiver_name"   => $receiver_name, "message"  => $message, "actions"  => $actions, "subject"  => $subject);

	                /*send the email*/
	                EmailModel::sendEmail($emailArray);

	                DB::commit();

	                $result_msg = "SUCCESSFULLY APPROVED";
	                return response()->json(['result'=>true, "message"=> $result_msg]);
	            }
	     	} 

	 		catch (\Exception $ex) {
	 		    DB::rollback();
	 		    return response()->json(['result' => false, "message" => $ex->getMessage()]);
	 		}
	    }

	      public function reject2(Request $request) {
	     	DB::beginTransaction();
	     	try {
	            /*validate all inputs*/
	            $validator = Validator::make($request->all(), [
	                'job_name'        => 'required|max:255',
	                'applicant_name'  => 'required|max:255',
	                'applicant_email' => 'required|max:255',
	                'application_id'  => 'required|exists:user_applications,id'
	            ]);

	            if ($validator->fails()) {
	                return response()->json(array(
	                    'result'    => false,
	                    'message'   => $validator->getMessageBag()->toArray()
	                ));
	            }
	            else {
	                /*application ID*/
	                $applicantId = $request->input('application_id');
	                /*change the application of the user into rejected*/
	                $application              = UserApplication::find($applicantId);
	                $application->status      = 3;
	                $application->isActive    = 1;
	                $application->save();

	                /*applicants info*/
	                $receiver_email = $request->input('applicant_email'); /*email_address*/
	                $receiver_name  = $request->input('applicant_name');  /*name*/
	                $job_name       = $request->input('job_name');  /*job_name*/

	                /*get email templates for rejected applicant*/
	                $rejectEmail = MaintenanceEmail::find(2);
	                /*get email's subject*/
	                $subject = $rejectEmail->subject;
	                /*put the job name on the subject of the email*/
	                $subject = str_replace("[application_name]", $job_name, $subject);

	                /*get email's message/body*/
	                $message = $rejectEmail->message;
	                /*put the job name on the message or body of the email*/
	                $message = str_replace("[application_name]", $job_name, $message);
	                $actions = "Please check your profile <a href='".url('applicant/jobs/'.$application->usersId)."'>here</a> for details.";

	                /*parameters for sending email*/
	                $emailArray = array("receiver_email"  => $receiver_email, "receiver_name"   => $receiver_name, "message"  => $message, "actions"  => $actions, "subject"  => $subject);
	                
	                /*send the email*/
	                EmailModel::sendEmail($emailArray);

	                DB::commit();

	                $result_msg = "SUCCESSFULLY REJECTED";
	                return response()->json(['result'=>true, "message"=> $result_msg]);
	            }
	 		} 

	 		catch (\Exception $ex) {
	 		    DB::rollback();
	 		    return response()->json(['result' => false, "message" => $ex->getMessage()]);
	 		}
	    }

	    /*list of applicant applications to specific job by type*/
	    public function applicationsByType($type, $id) {
	        /*user's id*/
	        $usersId = Auth::user()->id;

	        /*pending applications*/
	        if($type==="unprocessed") {
	            $status = 1;
	        }
	        /*scheduled applications*/
	        else if($type==="interview") {
	            $status = 2;
	        }
	        /*rejected applications*/
	        else {
	            $status = 3;
	        }

	        /*list of applicants who applied*/
	        $applicants = UserApplication::where("jobId", $id)->where("status", $status)->where("companyId", $usersId)->paginate(10);

	        /*get job title*/
	        $title = EmployerJob::where("id", $id)->first();

	        return view('employer.applicants.summary', compact('applicants', "title"));
	    }

	    /*list of applicant applications to specific job*/
	    public function applications($id) {
	        /*user's id*/
	        $usersId = Auth::user()->id;

	        /*list of applicants who applied*/
	        $applicants = UserApplication::where("jobId", $id)->where("companyId", $usersId)->paginate(10);

	        /*get job title*/
	        $title = EmployerJob::where("id", $id)->first();

	        return view('employer.applicants.summary', compact('applicants',"title"));
	    }

	    /*list of applicants who applied to this company*/
	    public function summary() {
	        /*user's id*/
	        $usersId  = Auth::user()->id;

	        /*list of applicants who applied*/
	        $applicants = UserApplication::where("companyId", $usersId)->paginate(10);

		    $currencies 	= ExtraCurrency::orderBy('name')->get();
		    $country 		= ExtraCountry::orderBy('nicename')->get();
		    $specialization = ExtraSpecialization::orderBy('name')->get();

	        return view('employer.applicants.summary', compact('applicants', 'currencies', 'country', 'specialization'));
	    }

	    /*list of applicants who applied to this company with filter*/
	    public function search() {
	        /*user's id*/
	        $usersId  = Auth::user()->id;

	        $currencies 	= ExtraCurrency::orderBy('name')->get();
		    $country 		= ExtraCountry::orderBy('nicename')->get();
		    $specialization = ExtraSpecialization::orderBy('name')->get();

	        /*list of applicants who applied*/
	       	$applicants = UserApplication::query()->where("companyId", $usersId)->with('application');

	        /*get filter inputs*/
			$get_spe 	= Input::get('specialization');
		    $get_loc 	= Input::get('location');
		    $get_title 	= Input::get('title');
		    $get_curr 	= Input::get('currency');
		    $get_salary = Input::get('salary');

	    	if (!empty($get_spe)) {
	            $applicants = $applicants->where(function($q) use($get_spe) {
		                        $q->whereHas('specialization', function($r) use($get_spe) {
		                            $r->where('specializationId', $get_spe); 
		                        })->orWhereHas('application', function($s) use($get_spe) {
		                            $sapplication;
		                        });
		                    });
	    	}

	    	if (!empty($get_loc)) {
	            $applicants = $applicants->where(function($q) use($get_loc) {
		                        $q->whereHas('application', function($r) use($get_loc) {
		                            $r->where('locationId', $get_loc); 
		                        })->orWhereHas('address', function($s) use($get_loc) {
		                            $s->where('countryId', $get_loc); 
		                        })->orWhereHas('location', function($s) use($get_loc) {
		                            $s->where('countryId', $get_loc); 
		                        });
		                    });
	    	}

	    	if (!empty($get_title)) {
	            $applicants = $applicants->where(function($q) use($get_title) {
			                        $q->whereHas('works', function($r) use($get_title) {
			                            $r->where('position', 'like', '%'.$get_title.'%'); 
			                        })->orWhereHas('application', function($s) use($get_title) {
			                                $s->where('title', 'like', '%'.$get_title.'%'); 
			                            });
		                        });
	        }

	    	if (!empty($get_curr)) {
	            $applicants = $applicants->where(function($q) use($get_curr) {
		                        $q->whereHas('details', function($r) use($get_curr) {
		                            $r->where('currencyId', $get_curr); 
		                        })->orWhereHas('application', function($s) use($get_curr) {
		                            $s->where('currencyId', $get_curr);
		                        });
		                    });
	    	}

	    	if (!empty($get_salary)) {
	    	    $applicants = $applicants->where(function($q) use($get_salary) {
		                        $q->whereHas('details', function($r) use($get_salary) {
		                            $r->where('number', "<=", $get_salary)->where('number', ">=", $get_salary);
		                        })->orWhereHas('application', function($s) use($get_salary) {
		                            $s->where('min', "<=", $get_salary)->where('max', ">=", $get_salary);
		                        });
		                    });
	    	}

	    	$applicants = $applicants->paginate(10);


	        return view('employer.applicants.summary', compact('applicants', 'currencies', 'country', 'specialization', 'get_spe', 'get_loc', 'get_title', 'get_curr', 'get_salary'));
	    }

	    /*list of saved applicant*/
	    public function invitations() {
	        /*user's id*/
	      	$usersId = Auth::user()->id;

	      	$users = UserInvitation::with('applicant', 'details', 'address', 'contacts', 'documents')->where('companyId', $usersId)->where("status", 1)->paginate(10);

       		$approves = UserInvitation::with('applicant', 'details', 'address', 'contacts', 'documents')->where('companyId', $usersId)->where("status", 2)->paginate(10);

       		$rejects = UserInvitation::with('applicant', 'details', 'address', 'contacts', 'documents')->where('companyId', $usersId)->where("status", 0)->paginate(10);

            return view('employer.applicants.invitations', compact('approves', 'users', 'rejects'));
	    }
	}
?>