<?php

    namespace App\Http\Controllers\Student;

	use DB;
	use Auth;
	use Mail;
	use File;
	use Alert;
	use Crypt;
	use Helper;
	use Redirect;
	use Carbon\Carbon;
	use App\MaintenanceLocale;
	use App\User;
	use App\EmailModel;
	use App\EmployerJob;
	use App\UserBookmark;
	use App\UserDocument;
	use App\UserInvitation;
	use App\UserApplication;
	use App\UserJobsResponse;
	use App\EmployerAgencies;
	use App\Jobs\SendEmailJob;
	use App\SubscriberAffilation;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Validator;

	class JobController extends Controller {
	    	
	    /*list of job application*/
	    public function index() {
	        $usersId 	= Auth::user()->id;

	    	$jobs 	= UserApplication::with("employer", "application", "response", "company_documents")->where("usersId", $usersId)->where('status', 2)->whereNotNull("scheduled")->whereHas('response')->orderBy('id', 'desc')->paginate(10);

			$approves = UserApplication::with("employer", "application", "response", "company_documents")->where('usersId', $usersId)->where('status', 2)->whereNull("scheduled")->doesntHave('response')->orderBy('id', 'desc')->paginate(10);

			$rejects = UserApplication::with("employer", "application", "response", "company_documents")->where('usersId', $usersId)->where('status', 3)->whereNull("scheduled")->doesntHave('response')->orderBy('id', 'desc')->paginate(10);

			$pending = UserApplication::with("employer", "application", "response", "company_documents")->where('usersId', $usersId)->where('status', 1)->whereNull("scheduled")->doesntHave('response')->orderBy('id', 'desc')->paginate(10);

			return view('student.jobs.index', compact("jobs", 'approves', 'rejects', 'pending'));
	    }

	    public function jobs() {
	        $id 		= Auth::user()->id;
	        $bookmarks 	= UserBookmark::where('usersId', $id)->paginate(10);

	        return view('student.jobs.saved', compact('bookmarks'));
	    }

	    public function show($id) {
	    	$profile = UserApplication::with("employer", "application", "response", "company_documents")->where("id", $id)->first();

			return view('student.jobs.information', compact("profile"));
	    }

	    /*apply to this job*/
	    public function store(Request $request) {
	        DB::beginTransaction();
	        try {    
	            $id 			= Auth::user()->id;

	            /*job id*/
	            $jobId 		= $request->input('jobId');

	        	/*company id*/
	        	$companyId 		= $request->input('organizationId');

	        	if($request->hasfile('resume')) {
	        		/*resume file*/
		        	$file_1 		= $request->file('resume');
		            $extension_1 	= $file_1->getClientOriginalExtension();
		            $contentType 	= $file_1->getMimeType();

		            $fileName 		= time();
		            $fileName 		= $fileName . "_resume." . $extension_1; 

		            /*put file to this location*/
		            $location_1 	= $id . "/documents/";

		            /*move file to the said location*/
		            $file_1->move(public_path()."/".$location_1, $fileName);
		        	$appliedStatus = true;
	        	}
		        else {
		        	$users = UserDocument::where("usersId", $id)->where("filetype", "resume")->first();

		        	if($users) {
		        		$fileName 		= $users->filename;
		        		$location_1 	= $users->path;
		        		$contentType 	= mime_content_type($location_1 . $fileName);
		        		$appliedStatus 	= true;
		        	}
		        	else {
		        		$appliedStatus = false;
		        	}
		        }

		        if($appliedStatus) {
			        	/*create application to this job*/
			        $job 					= new UserApplication();
			        $job->usersId 			= $id;
			        $job->jobId 			= $jobId;
			        $job->companyId 		= $companyId;
			        $job->path 				= $location_1;
			        $job->filename			= $fileName;
			        $job->status 			= 1;
			        $job->isActive 			= 1;

			        /*save to database*/
			        $job->save();
			        $lastInsertedId = $job->id;

			        $company 	= User::where("id", $companyId)->first();
			        $cdetail	= EmployerJob::where("id", $jobId)->first();

			        /*company email*/
			        $receiver_email = $company->email;
			        /*company employer name*/
			        $receiver_name 	= $company->firstName;

			        /*subject of the email*/
			        $subject 		= "Application for " . $cdetail->title;
			        /*content of the email*/
			        $message 		= "You have new application for " . $cdetail->title;

			        if($company->rolesId==3) {
						$actions = "Please check your profile <a href='".url('organization/applicants/'.$lastInsertedId)."'>here</a> for details.";
			        }
			        else {
						$actions = "Please check your profile <a href='".url('employer/applicants/'.$lastInsertedId)."'>here</a> for details.";
			        }

			        /*parameters for sending email*/
			        $emailArray = array("receiver_email" => $receiver_email,
			        					"receiver_name" => $receiver_name,
			        					"message" => $message,
			        					"actions" => $actions,
			        					"subject" => $subject);

			        /*send the email*/
			        EmailModel::sendEmail($emailArray);


			        $emailArray2 = array("companyId" 		=> $companyId,
			        					"companyName" 		=> $company->employer->company,
			        					"applicationName" 	=> $cdetail->title,
			        					"contentType" 		=> $contentType,
			        					"location_1" 		=> $location_1,
			        					"fileName" 			=> $fileName);

			        EmailModel::sendAffilations($emailArray2);
        			
			        DB::commit();
	        		alert()->success(MaintenanceLocale::getLocale(555), '');
	       	 		return Redirect::back();
		        }
		        else {
	    	 		alert()->error('Oops', 'There is no resume uploaded');
	    		 	return Redirect::back();
		        }
	            
	        } 

	        catch (\Exception $ex) {
	            DB::rollback();
	            return response()->json(['error' => $ex->getMessage()], 500);            
	        }

	    }

	    public function saved(Request $request) {
			DB::beginTransaction();
			try {    
				$id 		= Auth::user()->id;
				$key 		= $request->input('key');
				$jobId1 	= $request->input('jobId');
				$ajax 		= $request->input('ajax');
				$jobId 		= Crypt::decrypt($jobId1);

				$user = UserBookmark::where('jobId', $jobId)
						->where("usersId", $id)->first();

				if ($user === null) {
					$job 			= new UserBookmark();
					$job->usersId 	= $id;
					$job->jobId 	= $jobId;
					$job->save();
					$result_msg = MaintenanceLocale::getLocale(556);
				}
				else {
					UserBookmark::where("id", $user->id)->delete();
					$result_msg = MaintenanceLocale::getLocale(557);
				}
				/*save to database*/
				DB::commit();
			} 

			catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['error' => $ex->getMessage()], 500);            
			}

			if($ajax) {
				return response()->json(['result' => true, 'message' => $result_msg, 'jobId' => $key]);
			}
			else {
				alert()->success($result_msg, '');
				return Redirect::back();
			}

		}

	    public function response(Request $request) {
	    	DB::beginTransaction();
	        try {   
                $status     = $request->input('status');
                
                if($status==2) {
		        	$validator = Validator::make($request->all(), [
		        	    'status' 	=> 'required|int',
	                   	'date'      => 'required|after:'.date("Y-m-d H:i:s", time()),
		        	]);
		        }
		        else {
		        	$validator = Validator::make($request->all(), [
		        	    'status' 	=> 'required|int',
		        	]);
		        }

	        	/*if validator fails*/
	        	if ($validator->fails()) {
	        	    return response()->json(array(
	        	        'result'    => false,
	        	        'message'   => $validator->getMessageBag()->toArray()
	        	    ));
	        	}
	        	/*if validates successful*/ 
	        	else {
		            $usersId 			= Auth::user()->id;

		        	$dateTime 			= $request->input('date');
		        	$dateTime 			= Helper::getDate($dateTime);
		        	$jobApplicationId 	= $request->input('id');

		        	$parameters 			= array("jobApplicationId" => $jobApplicationId);
		        	$job 					= UserJobsResponse::firstOrNew($parameters);
		            $job->usersId 			= $usersId;
		            $job->jobApplicationId 	= $jobApplicationId;
		            $job->isAccept 			= $status;

		        	if($status==2) {
		        		$availability = $request->input('date');
		            	$job->availability 	= $availability;
		        	}

		       	 	$job->save();

		       	 	if($job->save()) {
				     	$firstName 		= ucfirst(Auth::user()->firstName);
				     	$lastName 		= ucfirst(Auth::user()->lastName);
			 			
			 			$job 	= UserApplication::with("employerd")->where("id", $jobApplicationId)->first();

		       	 		if($status==1) {
			 				$result_msg = MaintenanceLocale::getLocale(558);
		       	 			$message 	= $firstName . " " . $lastName . " will be able to attend to your invitation.";
		       	 		}
		       	 		else if($status==2) {
		       	 			$result_msg = MaintenanceLocale::getLocale(559);
		       	 			$message 	= $firstName . " " . $lastName . " would like to request for re-scheduled of date of your invitation on " . $dateTime . ".";
		       	 		}
		       	 		else {
		       	 			$result_msg = MaintenanceLocale::getLocale(246);
		       	 			$message 	= $firstName . " " . $lastName . " will not be able to attend to your invitation.";
		       	 		}

		       	 		if(!empty($job)) {
			       	 		$subject 		= $firstName . " " . $lastName . " responded to your invitation.";
		       	 			$receiver_name 	= $job->employerd->firstName ." ".$job->employerd->lastName;

		       	 			if($job->employerd->rolesId==3) {
								$actions = "Please check your profile <a href='".url('organization/applicants/'.$jobApplicationId)."'>here</a> for details.";
		       	 			}
		       	 			else {
								$actions = "Please check your profile <a href='".url('employer/applicants/'.$jobApplicationId)."'>here</a> for details.";

		       	 			}

		       	 			/*parameters for sending email*/
		       	 			$emailArray = array("receiver_email" 	=> $job->employerd->email,
		       	 								"receiver_name" 	=> $receiver_name,
		       	 								"message"	=> $message,
		       	 								"subject" 	=> $subject,
		       	 								"actions" 	=> $actions);
		       	 			/*send the email*/
		       	 			EmailModel::sendEmail($emailArray);
		       	 		}

		       	 	}
		       	 	
		            /*save to database*/
		            DB::commit();
		            return response()->json(['result' => true, 'message' => $result_msg]);          
		       	}  
	        } 

	        catch (\Exception $ex) {
	            DB::rollback();
	            return response()->json(['result' => false, 'message' => $ex->getMessage()], 500);            
	        }
	    }

	    /*list of saved applicant*/
	    public function invitations() {
	        /*user's id*/
	      	$usersId = Auth::user()->id;

	      	$jobs = UserInvitation::with('applicant', 'details', 'address', 'contacts', 'documents')->where('usersId', $usersId)->where("status", 1)->paginate(10);

	   		$approves = UserInvitation::with('applicant', 'details', 'address', 'contacts', 'documents')->where('usersId', $usersId)->where("status", 2)->paginate(10);

	   		$rejects = UserInvitation::with('applicant', 'details', 'address', 'contacts', 'documents')->where('usersId', $usersId)->where("status", 0)->paginate(10);

	        return view('student.jobs.invitations', compact('jobs', 'approves', 'rejects'));
	    }

	    public function invitations_response(Request $request) {
			DB::beginTransaction();
			try {    
				/*validate all inputs*/
				$validator = Validator::make($request->all(), [
				    'status' 	=> 'required|int',
				    'id'       	=> 'required|exists:user_invitations,id',
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
					$usersId 	= Auth::user()->id;
					$status 	= $request->input('status');
					$id 		= $request->input('id');

					if($status==0) {
						$result_msg = MaintenanceLocale::getLocale(246);
					}
					else {
						$result_msg = MaintenanceLocale::getLocale(558);
					}

					$invite 		= UserInvitation::find($id);
					$invite->status = $status;
					$invite->save();

					/*save to database*/
					DB::commit();

					return response()->json(['result' => true, 'message' => $result_msg]);
				}
			} 

			catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['result' => false, 'message' => $ex->getMessage()], 500);            
			}
		}
	}
?>