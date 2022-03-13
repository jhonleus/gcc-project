<?php

    namespace App\Http\Controllers\School;

    use DB;
    use Auth;
    use Alert;
    use Helper;
    use Carbon\Carbon;

    use App\EmailModel;
    use App\UserCourses;
    use App\UserDocument;
    use App\ExtraCountry;
    use App\SchoolDetail;
    use App\SchoolCourse;
    use App\ExtraCurrency;
    use App\ExtraStudentType;
    use App\SubscriptionDetails;
    use App\SubscriberTemplates;
    use App\SchoolCourseSchedule;
    use App\MaintenanceSubscriptions;
    use App\ExtraStudentSpecialization;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class CourseController extends Controller
    {
        /*course list page*/
        public function index() {
    		$usersId = Auth::user()->id;

    		/* get active posted courses of the school */
    		$courses = SchoolCourse::with('specializations', 'country', 'currency')->where('usersId', $usersId)->where("isActive", 1)->where("isDeleted", 0)->paginate(10);

    		/* get closed courses of the school */
    		$closes = SchoolCourse::with('specializations', 'country', 'currency')->where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 0)->paginate(10);

    		/* get deleted courses of the school */
    		$archives = SchoolCourse::with('specializations', 'country', 'currency')->where('usersId', $usersId)->where("isActive", 0)->where("isDeleted", 1)->paginate(10);

            /*users email templates*/
            $templates = SubscriberTemplates::where("usersId", $usersId)->get();

    		return view('school.courses.index', compact('courses', 'closes', 'templates', 'archives'));
        }

        /*create new course page*/
        public function create() {
        	$usersId = Auth::user()->id;

        	/*get date now*/
        	$now = Carbon::now()->format('Y-m-d');

    		/*get student type*/
    		$types 				= ExtraStudentType::orderBy('name')->get();

    		/*get specialization*/
    		$specializations 	= ExtraStudentSpecialization::orderBy('name')->get();

    		/*get countries*/
    		$countries 			= ExtraCountry::orderBy('nicename')->get();

    		/*get currencies*/
            $currencies 		= ExtraCurrency::orderBy('name')->get();

    		/*check if details are complete*/
    		$completeDetails 	= SchoolDetail::where('usersId', $usersId)->count();

           	$subscriptionCheck="";
           	$subscriptionEnded="";
           	$subscriptionLimit="";

    		/*if complete*/
    		if(!$completeDetails == 0) {
    			$disabled 			= false;
    			$completeDetails 	= true;

    			/*check if user subscribe*/
    			$subscriptionCheck 	= SubscriptionDetails::where('usersId', $usersId)
    									->count();

    			/*if subscribe*/
    			if($subscriptionCheck > 0) {
    				$disabled 			= false;
    				$subscriptionCheck 	= true;

    				/*check if current subscription is ended*/
                    $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                            $q->where('last_day', '>', $now)->orWhere('last_day', null);
                        })->first();

    				/*if ended*/
    				if(!$subscriptionEndedArray) {
    					$subscriptionEnded 	= true;
    					$disabled 			= true;
    				}
    				/*if not ended*/
    				else {
    					$subscriptionEnded 	= false;
    					$disabled 			= false;

    					/*get subscriptions limit*/
                        $limits     = MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();

                        if($limits->check_limit) {

                            $subscriptionLimit = 1;

                        }
                        else {

                            $limit_post = $limits->limit;

                            /*get count of posted course*/
                            $courses = SchoolCourse::where('usersId', $usersId)->where("isDeleted", 0)->where('isActive', 1)->count();

                            /*check if posted limit reached*/
                            $subscriptionLimit  = $limit_post - $courses;

                        }

    					/*if limit is 0*/
    					if($subscriptionLimit == 0) {
    						$subscriptionLimit 	= true;
    						$disabled 			= true;
    					}
    					/*if limit is greater than 0*/
    					else {
    						$subscriptionLimit 	= false;
    						$disabled 			= false;
    					}
    				}
    				
    			}
    			/*if no subscription*/
    			else {
    				$disabled 			= true;
    				$subscriptionCheck 	= false;
    			}
    		}
    		/*if not complete*/
    		else {
    			$disabled 			= true;
    			$completeDetails 	= false;	
    		}

    		return view('school.courses.create', compact('types', 'specializations', 'countries', 'subscriptionCheck', 'subscriptionEnded', 'subscriptionLimit', 'disabled', 'completeDetails', 'currencies'));
        }

       	/*STORE NEW COURSE INTO DATABASE*/
        public function store(Request $request) {
        	DB::beginTransaction();
        	try {
                $validator = Validator::make($request->all(), [
                    'details'       => 'required',
                    'dateSchedule'  => 'required',
                    'location'      => 'required|exists:extra_countries,id',
                    'currency'      => 'required|exists:extra_currencies,id',
                    'course'        => 'required|max:255',
                    'fee'           => 'required|max:255',
                    'start'         => 'required|after:'.date("Y-m-d H:i:s", time()),
                    'end'           => 'required|after:'.date("Y-m-d H:i:s", time()).'|after_or_equal:start|',
                    'registration'  => 'required|after:'.date("Y-m-d H:i:s", time()),
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'message' => $validator->getMessageBag()->toArray()
                    ));
                }
                else {
                    $usersId    = Auth::user()->id;
                    $now        = Carbon::now()->format('Y-m-d');

                    $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                            $q->where('last_day', '>', $now)->orWhere('last_day', null);
                        })->first();

                    $first_day = Carbon::now()->toDateTimeString();
                    $last_day  = Carbon::parse($first_day)->addDays($subscriptionEndedArray->subscription->expiration);

                    /*create new course*/
                    $school                     = new SchoolCourse();

                    $school->usersId            = $usersId;
                    $school->course             = $request->input('course');
                    $school->details            = $request->input('details');
                    $school->locationId         = $request->input('location');
                    $school->currencyId         = $request->input('currency');
                    $school->fee                = $request->input('fee');
                    $school->class_start        = $request->input('start');
                    $school->class_end          = $request->input('end');
                    $school->registration_end   = $request->input('registration');
                    $school->isActive           = 1;
                    $school->isDeleted          = 0;
                    $school->last_day           = $last_day;
                    $school->save();

                    $dateSchedule = $request->input('dateSchedule');

                    foreach ($dateSchedule as $key => $schedules) {
                        foreach ($schedules as $schedule) {
                            $dayName = Helper::getDayName($key);
                                
                            $scheduleDate = Helper::getTime($schedule[0]) . " - " . Helper::getTime($schedule[1]);

                            $schedule           = new SchoolCourseSchedule();
                            $schedule->usersId  = $usersId;
                            $schedule->courseId = $school->id;
                            $schedule->day      = $dayName;
                            $schedule->time     = $scheduleDate;
                            $schedule->array    = serialize($dateSchedule);
                            $schedule->save();
                        }
                        
                    }

                    DB::commit();
                    return response()->json(['result' => true, 'message' => "SUCCESSFULLY POSTED"]);
                }
        	} 

        	catch (\Exception $ex) {
        	    DB::rollback();
        	    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
        	}
        }

        /*edit course page*/
        public function edit($id) {
        	$usersId 	= Auth::user()->id;
        	$now 		= Carbon::now()->format('Y-m-d');

    		/*get student type*/
        	$types 				= ExtraStudentType::orderBy('name')->get();

    		/*get specialization*/
        	$specializations 	= ExtraStudentSpecialization::orderBy('name')->get();

    		/*get countries*/
        	$countries 			= ExtraCountry::orderBy('nicename')->get();

        	$courses = SchoolCourse::where('id', $id)->where("usersId", $usersId)->first();

        	if(!$courses) {
           		return redirect('school/course');
        	}

        	/*get currencies*/
            $currencies 		= ExtraCurrency::orderBy('name')->get();


    		/*check if current subscription is ended*/
            $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->first();
    		
    		/*disabled fields if subscription ended*/
    		if(!$subscriptionEndedArray) {
    			$subscriptionEnded = true;
    			$disabled = true; 
    		} 

    		else {
    			$subscriptionEnded = false;
    			$disabled = false;
    		}

        	return view('school.courses.create', compact('types', 'specializations', 'countries', 'courses' , 'disabled', 'subscriptionEnded', 'currencies'));
        }

       
       	/*UPDATE COURSE DETAILS INTO DATABASE*/
        public function update(Request $request) {
        	DB::beginTransaction();
        	try {
                $validator = Validator::make($request->all(), [
                    'courseId'      => 'required|exists:school_courses,id',
                    'details'       => 'required',
                    'dateSchedule'  => 'required',
                    'location'      => 'required|exists:extra_countries,id',
                    'currency'      => 'required|exists:extra_currencies,id',
                    'course'        => 'required|max:255',
                    'fee'           => 'required|max:255',
                    'start'         => 'required|after:'.date("Y-m-d H:i:s", time()),
                    'end'           => 'required|after:'.date("Y-m-d H:i:s", time()).'|after_or_equal:start|',
                    'registration'  => 'required|after:'.date("Y-m-d H:i:s", time()),
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                            'success' => false,
                            'message' => $validator->getMessageBag()->toArray()
                        ));
                }
                else {
                    SchoolCourseSchedule::where("courseId", $request->input('courseId'))->delete();

                    $id                         = $request->input('courseId');
                    $school                     = SchoolCourse::find($id);
                    $usersId                    = Auth::user()->id;
                    $school->usersId            = $usersId;
                    $school->course             = $request->input('course');
                    $school->locationId         = $request->input('location');
                    $school->currencyId         = $request->input('currency');
                    $school->fee                = $request->input('fee');
                    $school->class_start        = $request->input('start');
                    $school->class_end          = $request->input('end');
                    $school->registration_end   = $request->input('registration');
                
                    $school->save();

                    $dateSchedule = $request->input('dateSchedule');

                    foreach ($dateSchedule as $key => $schedules) {
                        foreach ($schedules as $schedule) {
                            $dayName = Helper::getDayName($key);
                                
                            $scheduleDate = Helper::getTime($schedule[0]) . " - " . Helper::getTime($schedule[1]);

                            $schedule       = new SchoolCourseSchedule();
                            $schedule->usersId  = $usersId;
                            $schedule->courseId = $school->id;
                            $schedule->day      = $dayName;
                            $schedule->time     = $scheduleDate;
                            $schedule->array    = serialize($dateSchedule);
                            $schedule->save();
                        }
                        
                    }

                    DB::commit();
                    return response()->json(['result' => true, 'message' => "SUCCESSFULLY UPDATED"]);
                }
        	} 


        	catch (\Exception $ex) {
        	    DB::rollback();
        	    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
        	}
        }

       	/*DELETE COURSE INTO DATABASE*/
        public function delete(Request $request) {
        	DB::beginTransaction();
        	try {
        		$id 				= $request->input("id");
        		$status 			= $request->input("status");

                /*validate required fields*/
                $validator = Validator::make($request->all(), [
                    'id'        => 'required|exists:school_courses,id',
                    'status'    => 'required|int',
                ]);
                
                /*if validation fails*/
                if ($validator->fails()) {
                    return response()->json(array(
                        'result'    => false,
                        'message'   => $validator->getMessageBag()->toArray()
                    ));
                }
                else {
            		/*if status 1 means course is already deleted then update the status into active*/
            		if($status==1) {
            			$new_stat 		= 1;
            			$delete_stat 	= 0;
            			$usersId 		= Auth::user()->id;

            			/*get date now*/
            			$now = Carbon::now()->format('Y-m-d');

        				/*check if current subscription is ended*/
                        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                                   $q->where('last_day', '>', $now)->orWhere('last_day', null);
                               })->first();

        				/*if ended*/
        				if(!$subscriptionEndedArray) {
        					$insertStatus = false;
            				$result_msg = "Your subscription has been ended, please renew your subscription <a href='/pricing'>here!</a>";
        				}
        				/*if not ended*/
        				else {
        					/*get subscriptions limit*/
                            $limits     = MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();
        					
                            if($limits->check_limit) {

                                $subscriptionLimit = 1;

                            }
                            else {

                                $limit_post = $limits->limit;

                                /*get count of posted course*/
                                $courses = SchoolCourse::where('usersId', $usersId)->where("isDeleted", 0)->where('isActive', 1)->count();

                                /*check if posted limit reached*/
                                $subscriptionLimit  = $limit_post - $courses;

                            }

        					/*if limit is 0*/
        					if($subscriptionLimit == 0) {
        						$insertStatus = false;
            					$result_msg = "Your course posting reached its limit, you can upgrade your subscription <a href='/pricing'>here!</a>";
        					}
        					/*if limit is greater than 0*/
        					else {
        						$insertStatus = true;
            					$result_msg = "SUCCESSFULLY RESTORED";

                                $first_day = Carbon::now()->toDateTimeString();
                                $last_day  = Carbon::parse($first_day)->addDays($subscriptionEndedArray->subscription->expiration);
        					}
        				}
            		}
            		/*else if status is not yet deleted then delete the course*/
            		else {
            			$new_stat 		= 0;
            			$delete_stat	= 1;
        				$insertStatus 	= true;
            			$result_msg 	= "SUCCESSFULLY DELETED";

            			/*get all users who enrolled to this course*/
            	   		$users = UserCourses::where("courseId", $id)->where("isActive", 1)->with("user")->get();

            	   		foreach ($users as $user) {
            	   			/*if user is approve or scheduled*/
            	   			if($user->status==2) {
            	   				$new_status = 2;
            	   			}
            	   			/*if pending or declined*/
            	   			else {
            	   				$new_status = 0;
            	   			}
        			
        					/*inactive all users who enrolled*/    	   			
            	   			$editData = array("isActive" => 0, "status" => $new_status);

            	   			/*update its status*/
        		    		DB::table('user_courses_application')->where('id', $user->id)->where('usersId', $user->usersId)->update($editData);
            	   		}
            		}

            		if($insertStatus) {
        	    		/*change the status of the course*/
        	    	    $school 			= SchoolCourse::find($id);
        	    	   	$school->isActive 	= $new_stat;
        	    	   	$school->isDeleted 	= $delete_stat;

                        if($status==1) {
                            $school->last_day = $last_day;
                        }

                    	$school->save();
        	   		}
                    DB::commit();
                }

                return response()->json(['result'=>$insertStatus,'message'=>$result_msg]);
        	} 

        	catch (\Exception $ex) {
        	    DB::rollback();
        	    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
        	}
        }

       	/*CLOSED THE COURSE STATUS*/
        public function close(Request $request) {
        	DB::beginTransaction();
        	try {
        	   	$id 				= $request->input("id");
        		$status 			= $request->input("status");
        		$course_name 		= $request->input("course_name");
        		$usersId 			= Auth::user()->id;

                /*validate required fields*/
                $validator = Validator::make($request->all(), [
                    'id'            => 'required|exists:school_courses,id',
                    'status'        => 'required|int',
                    'course_name'   => 'required|max:255',
                ]);
                /*if validation fails*/
                if ($validator->fails()) {
                    return response()->json(array(
                        'result'    => false,
                        'message'   => $validator->getMessageBag()->toArray()
                    ));
                }
                /*if meets all the validation*/
                else {

                    /*if status 0 means course is already closed then update the status into active*/
            		if($status==0) {
            			$new_stat 	= 1;

            			/*get date now*/
            			$now = Carbon::now()->format('Y-m-d');

        				/*check if current subscription is ended*/
                        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $usersId)->orderBy('id', 'DESC')->where(function($q) use($now) {
                                $q->where('last_day', '>', $now)->orWhere('last_day', null);
                            })->first();

        				/*if ended*/
        				if(!$subscriptionEndedArray) {
        					$insertStatus = false;
            				$result_msg = "Your subscription has been ended, please renew your subscription <a href='/pricing'>here!</a>";
        				}
        				/*if not ended*/
        				else {
        					/*get subscriptions limit*/
        					$limits 	= MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();
        					
                            if($limits->check_limit) {

                                $subscriptionLimit = 1;

                            }
                            else {

                                $limit_post = $limits->limit;

                                /*get count of posted course*/
                                $courses = SchoolCourse::where('usersId', $usersId)->where("isDeleted", 0)->where('isActive', 1)->count();

                                /*check if posted limit reached*/
                                $subscriptionLimit  = $limit_post - $courses;

                            }

        					/*if limit is 0*/
        					if($subscriptionLimit == 0) {
        						$insertStatus = false;
            					$result_msg = "Your course posting reached its limit, you can upgrade your subscription <a href='/pricing'>here!</a>";
        					}
        					/*if limit is greater than 0*/
        					else {
        						$insertStatus = true;
            					$result_msg = "SUCCESSFULLY RESTORED";

                                $first_day = Carbon::now()->toDateTimeString();
                                $last_day  = Carbon::parse($first_day)->addDays($subscriptionEndedArray->subscription->expiration);
        					}
        				}
            		}
            		/*if status 0 means course is active then closed the course*/
            		else {
            			$new_stat 		= 0;
        				$insertStatus 	= true;
            			$result_msg 	= "SUCCESSFULLY CLOSED";

            			/*id of the email template that will use*/
            	   		$templateId = $request->input("template_id");

            	   		if($templateId) {
        	    	   		/*get templates details*/
        	    	   		$template 	= SubscriberTemplates::find($templateId);
        	    	   		$subject 	= $template->subject;
        	    	   		$message 	= $template->message;
            	   		}
            	   		else {
        		        	/*create new template*/
        					$template 			= new SubscriberTemplates();
        					$template->usersId 	= $usersId;
        					/*subject of the email*/
        					$template->subject 	= $request->input("subject");
        					/*content of the email*/
        					$template->message 	= $request->input("message");
        					$template->save();

            	   			$subject 	= $request->input("subject");
            	   			$message 	= $request->input("message");
            	   		}
        				$subject  	= str_replace("[application_name]",$course_name,$subject);
        				$message  	= str_replace("[application_name]",$course_name,$message);

            	   		/*get all users who enrolled to this course*/
            	   		$users = UserCourses::where("courseId", $id)
            	   				->where("isActive", 1)
            	   				->with("user")->get();

            	   		foreach ($users as $user) {
        	   				$receiver_name 	= $user->user->firstName." ".$user->user->lastName;
        	   				$receiver_email = $user->user->email;
        	   				
        	   				/*parameters for sending email*/
        	   				$emailArray = array("receiver_email" => $receiver_email,
        	   									"receiver_name" => $receiver_name,
        	   									"message" => $message,
        	   									"subject" => $subject);

        	   				/*send the email*/
        	   				EmailModel::sendEmail($emailArray);

        	   				/*if user is approved or scheduled*/
        	   				if($user->status==2) {
        	   					$new_status = 2;
        	   				}
        	   				/*if user was declined or pending*/
        	   				else {
        	   					$new_status = 0;
        	   				}

        	   				/*change the status of the application into inactive*/
            	   			$editData = array("isActive" => 0, "status" => $new_status);

            	   			/*update the status*/
        		    		DB::table('user_courses_application')->where('id', $user->id)->where('usersId', $user->usersId)->update($editData);
            	   		}
            		}

            		if($insertStatus) {
        				/*update course into database*/
        			    $school 			= SchoolCourse::find($id);
        			   	$school->isActive 	= $new_stat;
        			   	$school->isDeleted 	= 0;

                        if($status==0) {
                            $school->last_day = $last_day;
                        }

        		        $school->save();
            		}
            		DB::commit();

                    return response()->json(['result'=>$insertStatus,"message"=>$result_msg]);
                }
        	} 


        	catch (\Exception $ex) {
        	    DB::rollback();
        	    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
        	}
        }

        public function summary() {
            $usersId = Auth::user()->id;

            $courses = SchoolCourse::where("usersId", $usersId)->paginate(10);

            return view('school.courses.summary', compact("courses"));
        }
    }
?>
