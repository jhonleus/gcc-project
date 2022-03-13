<?php 
	namespace App\Http\Controllers\Employer;

	use DB;
	use Auth;
	use Alert;
	use \Carbon\Carbon;

	use App\EmailModel;
	use App\EmployerJob;
	use App\ExtraCountry;
	use App\UserDocument;
	use App\ExtraPosition;
	use App\ExtraCurrency;
	use App\EmployerDetail;
	use App\ExtraEmployment;
	use App\UserApplication;
	use App\ExtraSpecialization;
	use App\SubscriptionDetails;
	use App\MaintenanceSubscriptions;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;

	class JobController extends Controller {

		/*list of jobs*/
    	public function index() {

			return view('subscriber.payment.maintenance');
    		/*user's id
			$usersId = Auth::user()->id;

			/* get active posted job of the employer 
			$jobs = EmployerJob::with('employments', 'positions', 'currency')->where('usersId', $usersId)->where("isActive", 1)->where("isDeleted", 0)->orderBy('id', 'desc')->paginate(10);

			/* get closed posted job of the employer 
			$closes = EmployerJob::with('employments', 'positions', 'currency')->where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 0)->orderBy('id', 'desc')->paginate(10);

			/* get deleted posted job of the employer 
			$archives = EmployerJob::with('employments', 'positions', 'currency')->where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 1)->orderBy('id', 'desc')->paginate(10);

			return view('employer.jobs.index', compact('jobs', 'closes', 'archives'));*/
		}

	    public function create() {

			return view('subscriber.payment.maintenance');

			/*
	    	$usersId 	= Auth::user()->id;

	    	/*get date now
	    	$now = Carbon::now()->format('Y-m-d');

			/*get job type
			$types 	= ExtraEmployment::orderBy('name')->get();

			/*get specialization
			$specializations = ExtraSpecialization::orderBy('name')->get();

			/*get countries
			$countries = ExtraCountry::orderBy('nicename')->get();

			/*positions
	        $positions = ExtraPosition::orderBy('name')->get();

	        $currencies = ExtraCurrency::orderBy('name')->get();

			/*check if details are complete
			$completeDetails = EmployerDetail::where('usersId', $usersId)->count();

	        $subscriptionCheck="";
	        $subscriptionEnded="";
	        $subscriptionLimit="";

			/*if complete
			if(!$completeDetails == 0) {
				$disabled 			= false;
				$completeDetails 	= true;	

				/*check if user subscribe
				$subscriptionCheck 	= SubscriptionDetails::where('usersId', $usersId)->count();

				/*if subscribe
				if($subscriptionCheck > 0) {
					$disabled 			= false;
					$subscriptionCheck 	= true;

					/*check if current subscription is ended
			        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
		                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
		                })->first();

					/*if ended
					if(!$subscriptionEndedArray) {
						$subscriptionEnded 	= true;
						$disabled 			= true;
					}
					/*if not ended
					else {
						$subscriptionEnded 	= false;
						$disabled 			= false;

						/*get subscriptions limit
						$limits 	= MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();
						
						if($limits->check_limit) {

							$subscriptionLimit = 1;

						}
						else {

							$limit_post = $limits->limit;

							/*get count of posted course
							$courses = EmployerJob::where('usersId', $usersId)->where("isDeleted", 0)->where('isActive', 1)->count();

							/*check if posted limit reached
							$subscriptionLimit 	= $limit_post - $courses;

						}

						/*if limit is 0
						if($subscriptionLimit <= 0) {
							$subscriptionLimit 	= true;
							$disabled 			= true;
						}
						/*if limit is greater than 0
						else {
							$subscriptionLimit 	= false;
							$disabled 			= false;
						}
					}
					
				}
				/*if not subscribe
				else {
					$disabled 			= true;
					$subscriptionCheck 	= false;
				}
			}
			/*if not complete
			else {
				$disabled 			= true;
				$completeDetails 	= false;	
			}

			return view('employer.jobs.create', compact('types', 'specializations', 'countries', 'subscriptionCheck', 'subscriptionEnded', 'subscriptionLimit', 'disabled', 'completeDetails', 'positions', 'currencies'));*/
	    }

	   	/*STORE NEW JOB INTO DATABASE*/
	    public function store(Request $request) {

			return view('subscriber.payment.maintenance');
	        /*$attributes = request()->validate([
	            'job_title'         => 'required|max:255',
	            'employment'        => 'required|exists:extra_employments,id',
	            'position'          => 'required|exists:extra_positions,id',
	            'location'          => 'required|exists:extra_countries,id',
	            'city'              => 'required|max:255',
	            'specialization'    => 'required|exists:extra_specializations,id',
	            'currency'          => 'required|exists:extra_currencies,id',
	            'max'               => 'required|integer',
	            'min'               => 'required|integer',
	            'responsibility'    => 'required',
	            'qualification'     => 'required',
	            'description'       => 'required',
	            'job_order'         => 'required',
	            //'partners'          => 'required|exists:users,id',
	        ]);

	    	DB::beginTransaction();
	    	try {
	    	    $usersId 	= Auth::user()->id;
	    		$now 		= Carbon::now()->format('Y-m-d');

    	        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                        $q->where('last_day', '>', $now)->orWhere('last_day', null);
                    })->first();

        		$first_day = Carbon::now()->toDateTimeString();
       	 		$last_day  = Carbon::parse($first_day)->addDays($subscriptionEndedArray->subscription->expiration);
	    	    /*if posted course has a job order create new job
	            $school                     = new EmployerJob();
	            $school->usersId            = $usersId;
	            $school->title              = $request->input('job_title');
	            $school->employmentId       = $request->input('employment');
	            $school->positionId         = $request->input('position');
	            $school->locationId         = $request->input('location');
	            $school->locationCity       = $request->input('city');
	            $school->specializationId   = $request->input('specialization');
	            $school->currencyId         = $request->input('currency');
	            $school->max                = $request->input('max');
	            $school->min                = $request->input('min');
	            $school->responsibilities   = $request->input('responsibility');
	            $school->qualification      = $request->input('qualification');
	            $school->description        = $request->input('description');
	            $school->last_day        	= $last_day;

	            $file       = $request->file('job_order');
	            $ext        = $file->getClientOriginalExtension();
	            $time       = time();
	            $fileName   = $time . "." . $ext;
	            $location   = $usersId."/documents/job_order/";
	            $file->move(public_path()."/".$location, $fileName);

	            $school->jobOrder           = $location . $fileName;
	            $school->isActive           = 1;
	            $school->isDeleted          = 0;
	            $school->isValidate         = 0;

	            /*save to database
	            $school->save();

	    	    DB::commit();

	            alert()->success('SUCCESSFULLY POSTED','');
	            return redirect('employer/jobs');
	    	} 

	        catch (\Exception $ex) {
	    	    DB::rollback();
	    	    return response()->json(['error' => $ex->getMessage()], 500);
	    	}*/
	    }

	    /*EDIT JOB*/
	    public function edit($id) {

			return view('subscriber.payment.maintenance');

	    	/*
	    	$usersId 	= Auth::user()->id;
	    	$now 		= Carbon::now()->format('Y-m-d');

			/*get job type
	    	$types = ExtraEmployment::orderBy('name')->get();

			/*get specialization
	    	$specializations = ExtraSpecialization::orderBy('name')->get();

			/*get countries
	    	$countries = ExtraCountry::orderBy('nicename')->get();

			/*get job details
	    	$jobs = EmployerJob::where('id', $id)->where("usersId", $usersId)->first();

	        if(!$jobs) {
	            return redirect('employer/jobs');
	        }

			/*get positions
	        $positions = ExtraPosition::orderBy('name')->get();

	        /*get currency
	        $currencies = ExtraCurrency::orderBy('name')->get();

			/*check if current subscription is ended
	        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->first();
			
			/*disabled fields if subscription ended
			if(!$subscriptionEndedArray) {
				$subscriptionEnded = true;
				$disabled = true; 
			} 
	        else {
				$subscriptionEnded = false;
				$disabled = false;
			}

	    	return view('employer.jobs.create', compact('types', 'specializations', 'countries', 'jobs' , 'disabled', 'subscriptionEnded', 'positions' , 'currencies'));*/
	    }

	   
	   	/*UPDATE JOB DETAILS INTO DATABASE*/
	    public function update(Request $request, $id) {

			return view('subscriber.payment.maintenance');
	    	
			/*
	    	$usersId = Auth::user()->id;

	        $attributes = request()->validate([
	            'id'                => 'required|exists:employer_jobs,id',
	            'job_title'         => 'required|max:255',
	            'employment'        => 'required|exists:extra_employments,id',
	            'position'          => 'required|exists:extra_positions,id',
	            'location'          => 'required|exists:extra_countries,id',
	            'city'              => 'required|max:255',
	            'specialization'    => 'required|exists:extra_specializations,id',
	            'currency'          => 'required|exists:extra_currencies,id',
	            'max'               => 'required|integer',
	            'min'               => 'required|integer',
	            'responsibility'    => 'required',
	            'qualification'     => 'required',
	            'description'       => 'required',
	            //'job_order'         => 'required',
	            //'partners'          => 'required|exists:users,id',
	        ]);

	    	DB::beginTransaction();
	    	try {
	    		/*update job details
	    	    $job = EmployerJob::where('id', $id)->where('usersId', $usersId)->first();
	    	    $job->title				= $request->input('job_title');
	    	    $job->employmentId		= $request->input('employment');
	    	    $job->positionId	    = $request->input('position');
	    	    $job->locationId	    = $request->input('location');
	            $job->locationCity      = $request->input('city');
	    	    $job->specializationId	= $request->input('specialization');
	    	    $job->currencyId	    = $request->input('currency');
	    	    $job->max				= $request->input('max');
	    	    $job->min				= $request->input('min');
	    	    $job->responsibilities	= $request->input('responsibility');
	    	    $job->qualification		= $request->input('qualification');
	    	    $job->description		= $request->input('description');
	    		
	    		/*save to database
	            $job->save();

	    	    DB::commit();

	            alert()->success('SUCCESSFULLY UPDATED','');
	            return redirect('employer/jobs');
	    	} 

	        catch (\Exception $ex) {
	    	    DB::rollback();
	    	    return response()->json(['error' => $ex->getMessage()], 500);
	    	}*/
	    }

	    /*DELETE JOB INTO DATABASE*/
	    public function delete(Request $request) {

			return view('subscriber.payment.maintenance');

	    	/*
	    	DB::beginTransaction();
	    	try {
	    		$id 		= $request->input("id");
	    		$status 	= $request->input("status");
	    		$job_name 	= $request->input("job_name");

	            /*validate required fields
	            if($status==1) {
	                $validator = Validator::make($request->all(), [
	                    'id'        => 'required|exists:employer_jobs,id',
	                    'status'    => 'required|int',
	                    'job_order' => 'required|not_in:undefined',
	                ]);
	            }
	            else {
	                $validator = Validator::make($request->all(), [
	                    'id'        => 'required|exists:employer_jobs,id',
	                    'status'    => 'required|int',
	                ]);
	            }
	            
	            /*if validation fails
	            if ($validator->fails()) {
	                return response()->json(array(
	                    'result'    => false,
	                    'message'   => $validator->getMessageBag()->toArray()
	                ));
	            }
	            /*if meets all the validation
	            else {
	        		/*if status 1 means course is already deleted then update the status into active
	        		if($status==1) {
	        			$new_stat 		= 1;
	        			$delete_stat 	= 0;
	        			$usersId 		= Auth::user()->id;

	        			/*get date now
	        			$now = Carbon::now()->format('Y-m-d');

	                    /*check if current subscription is ended
            	        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                                $q->where('last_day', '>', $now)->orWhere('last_day', null);
                            })->first();

	    				/*if ended
	    				if(!$subscriptionEndedArray) {
	    					$insertStatus = false;
	                        $changeStatus = false;
	                        $change = false;
	        				$result_msg = "Your subscription has been ended, please renew your subscription <a href='/pricing'>here!</a>";
	    				}
	    				/*if not ended
	    				else {
	    					/*get subscriptions limit
	    					$limits 	= MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();
	    					
	    					if($limits->check_limit) {

	    						$subscriptionLimit = 1;

	    					}
	    					else {

	    						$limit_post = $limits->limit;

	    						/*get count of posted course
	    						$courses = EmployerJob::where('usersId', $usersId)->where("isDeleted", 0)->where('isActive', 1)->count();

	    						/*check if posted limit reached
	    						$subscriptionLimit 	= $limit_post - $courses;

	    					}

	    					/*if limit is 0
	    					if($subscriptionLimit <= 0) {
	    						$insertStatus = false;
	                            $changeStatus = false;
	        					$result_msg = "Your job posting reached its limit, you can upgrade your subscription <a href='/pricing'>here!</a>";
	    					}
	    					/*if limit is greater than 0
	    					else {
	    						$first_day = Carbon::now()->toDateTimeString();
	    						$last_day  = Carbon::parse($first_day)->addDays($subscriptionEndedArray->subscription->expiration);

	    						$insertStatus = true;
	                            $changeStatus = true;
	        					$result_msg = "SUCCESSFULLY RESTORED";
	    					}
	    				}
	        		}
	        		/*else if status is not yet deleted then delete the course
	        		else {
	        			$new_stat 		= 0;
	        			$delete_stat	= 1;
	    				$insertStatus 	= true;
	                    $changeStatus   = false;
	        			$result_msg 	= "SUCCESSFULLY DELETED";

	        			/*get all users who enrolled to this job
	        	   		$users = UserApplication::where("jobId", $id)
	        	   				->where("isActive", 1);

	        	   		foreach ($users as $user) {
	        	   			/*if user is approve or scheduled
	        	   			if($user->status==2) {
	        	   				$new_status = 2;
	        	   			}
	        	   			/*if pending or declined
	        	   			else {
	        	   				$new_status = 3;
	        	   			}
	    			
	    					/*inactive all users who enrolled	   			
	        	   			$editData = array("isActive" => 0, "status" => $new_status);

	        	   			/*update its status
	    		    		DB::table('user_applications')->where('id', $user->id)->where('usersId', $user->usersId)->update($editData);
	        	   		}
	        		}

	        		if($insertStatus) {
	    				/*change the status of the job
	    			    $job 			 = EmployerJob::find($id);
	    			   	$job->isActive 	 = $new_stat;
	    			   	$job->isDeleted  = $delete_stat;
	                    $job->isValidate = 0;

	                    if($changeStatus) {
	                        $file       = $request->file('job_order');
	                        $ext        = $file->getClientOriginalExtension();
	                        $time       = time();
	                        $fileName   = $time . "." . $ext;

	                        $location   = $id."/documents/job_order/";
	                        $file->move(public_path()."/".$location, $fileName);

	                        $job->last_day = $last_day;
	                        $job->jobOrder = $location . $fileName;
	                    }

	                	$job->save();
	        		}

	        	    DB::commit();
	                return response()->json(['result'=>$insertStatus,'message'=>$result_msg]);
	            }
	    	} 

	    	catch (\Exception $ex) {
	    	    DB::rollback();
	    	    return response()->json(['result' => $ex->getMessage()], 500);
	    	}*/
	    }

	   	/*CLOSED THE JOB STATUS*/
	    public function close(Request $request) {

			return view('subscriber.payment.maintenance');

	    	/*
	    	DB::beginTransaction();
	    	try {
	    	   	$id 		= $request->input("id");
	    		$status 	= $request->input("status");
	    		$job_name 	= $request->input("job_name");
	    		$usersId 	= Auth::user()->id;
	            
	            if($status==0) {
	            	/*validate required fields
	            	$validator = Validator::make($request->all(), [
	            	    'id'        => 'required|exists:employer_jobs,id',
	            	    'status'    => 'required|int',
	            	    'job_name'  => 'required|max:255',
	                    'job_order' => 'required|not_in:undefined',
	            	]);
	            }
	            else {
	            	/*validate required fields
	            	$validator = Validator::make($request->all(), [
	            	    'id'        => 'required|exists:employer_jobs,id',
	            	    'status'    => 'required|int',
	            	    'job_name'  => 'required|max:255',
	            	    'subject'  	=> 'required|max:255',
	                    'message'  	=> 'required',
	            	]);
	            }
	            
	            /*if validation fails
	            if ($validator->fails()) {
	                return response()->json(array(
	                    'result'    => false,
	                    'message'   => $validator->getMessageBag()->toArray()
	                ));
	            }
	            /*if meets all the validation
	            else {
	                /*if status 0 means course is already closed then update the status into active
	                if($status==0) {
	                    $new_stat   	= 1;
	                    /*get date now
	                    $now = Carbon::now()->format('Y-m-d');

	                    /*check if current subscription is ended
            	        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                                $q->where('last_day', '>', $now)->orWhere('last_day', null);
                            })->first();

	                    /*if ended
	                    if(!$subscriptionEndedArray) {
	                    	$changeStatus = false;
	                        $insertStatus = false;
	                        $result_msg = "Your subscription has been ended, please renew your subscription <a href='/pricing'>here!</a>";
	                    }
	                    /*if not ended
	                    else {
	                        /*get subscriptions limit
	                        $limits     = MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();
	                        
	                        if($limits->check_limit) {

	                        	$subscriptionLimit = 1;

	                        }
	                        else {

	                        	$limit_post = $limits->limit;

	                        	/*get count of posted course
	                        	$courses = EmployerJob::where('usersId', $usersId)->where("isDeleted", 0)->where('isActive', 1)->count();

	                        	/*check if posted limit reached
	                        	$subscriptionLimit 	= $limit_post - $courses;

	                        }

	                        /*if limit is 0
	                        if($subscriptionLimit <= 0) {
	                    		$changeStatus = false;
	                            $insertStatus = false;
	                            $result_msg = "Your job posting reached its limit, you can upgrade your subscription <a href='/pricing'>here!</a>";
	                        }
	                        /*if limit is greater than 0
	                        else {
	                    		$changeStatus = true;
	                            $insertStatus = true;
	                            $result_msg = "SUCCESSFULLY REOPENED";

	                            $first_day = Carbon::now()->toDateTimeString();
	                            $last_day  = Carbon::parse($first_day)->addDays($subscriptionEndedArray->subscription->expiration);
	                        }
	                    }
	                }
	                /*if status 0 means course is active then closed the course
	                else {
	                    $new_stat       = 0;
	                    $insertStatus   = true;
	                   	$changeStatus 	= false;
	                    $result_msg     = "SUCCESSFULLY CLOSED";

	                    $subject    = $request->input("subject");
	                    $message    = $request->input("message");

	                    $subject    = str_replace("[application_name]",$job_name,$subject);
	                    $message    = str_replace("[application_name]",$job_name,$message);

	                    /*get all users who enrolled to this job
	                    $users = UserApplication::where("jobId", $id)
	                            ->where("isActive", 1)
	                            ->with("applicant")->get();

	                    foreach ($users as $user) {
	                        $receiver_name  = $user->applicant->firstName." ".$user->applicant->lastName;
	                        $receiver_email = $user->applicant->email;
	                        
	                        /*parameters for sending email
	                        $emailArray = array("receiver_email" => $receiver_email,
	                                            "receiver_name" => $receiver_name,
	                                            "message" => $message,
	                                            "subject" => $subject);

	                        /*send the email
	                        EmailModel::sendEmail($emailArray);

	                        /*if user is approved or scheduled
	                        if($user->status==2) {
	                            $new_status = 2;
	                        }
	                        /*if user was declined or pending
	                        else {
	                            $new_status = 3;
	                        }

	                        /*change the status of the application into inactive
	                        $editData = array("isActive" => 0, "status" => $new_status);

	                        /*update the status
	                        DB::table('user_applications')->where('id', $user->id)->where('usersId', $user->usersId)->update($editData);
	                    }
	                }

	                if($insertStatus) {
	                    /*update job into database
	                    $school             = EmployerJob::find($id);
	                    $school->isActive   = $new_stat;
	                    $school->isValidate = 0;

	                    if($changeStatus) {
	                        $file       = $request->file('job_order');
	                        $ext        = $file->getClientOriginalExtension();
	                        $time       = time();
	                        $fileName   = $time . "." . $ext;

	                        $location   = $id."/documents/job_order/";
	                        $file->move(public_path()."/".$location, $fileName);

	                        $school->last_day = $last_day;
	                        $school->jobOrder = $location . $fileName;
	                    }

	                    $school->isDeleted  = 0;
	                    $school->save();
	                }
	                
	                DB::commit();
	                return response()->json(['result'=>$insertStatus,"message"=>$result_msg]);
	            }
	    	} 


	    	catch (\Exception $ex) {
	    	    DB::rollback();
	    	    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
	    	}*/
	    }

	    public function summary() {

			return view('subscriber.payment.maintenance');

	    	/*
	        $usersId = Auth::user()->id;

	        $jobs = EmployerJob::where("usersId", $usersId)->paginate(10);

	        return view('employer.jobs.summary', compact("jobs"));*/
	    }
	}	
?>