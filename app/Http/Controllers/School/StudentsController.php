<?php
	namespace App\Http\Controllers\School;

	use DB;
	use Auth;
	use Redirect;

	use App\EmailModel;
	use App\UserCourses;
	use App\ExtraGender;
	use App\SchoolCourse;
	use App\ExtraCountry;
	use App\PaymentDetails;
	use App\UserCourseResponse;
	use App\SubscriberTemplates;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Validator;

	class StudentsController extends Controller {
    	public function index() {
	    	/*user's id*/
			$usersId = Auth::user()->id;

			/* get new students who enrolled */
			$users 			= UserCourses::with('user', 'detail', 'address', 'contact', 'course', 'documents')->where('companyId', $usersId)->where('status', '1')->orderBy('id', 'desc')->paginate(10);

			/*get students who are scheduled for enrolment*/
			$approves 			= UserCourses::with('user', 'detail', 'address', 'contact', 'course', 'documents')->where('companyId', $usersId)->where('status', '2')->orderBy('id', 'desc')->paginate(10);

			$schedules 			= UserCourses::with('user', 'detail', 'address', 'contact', 'course', 'documents')->where('companyId', $usersId)->where('status', '2')->whereNotNull("schedule_date")->orderBy('id', 'desc')->paginate(10);

			/*get students who are rejected for enrolment*/
			$rejects 		= UserCourses::with('user', 'detail', 'address', 'contact', 'course', 'documents')->where('companyId', $usersId)->where('status', '0')->orderBy('id', 'desc')->paginate(10);

	        $checkEmailStatus = PaymentDetails::checkEmailStatus();
			$templates = SubscriberTemplates::where("usersId", $usersId)->get();

			return view('school.students.index', compact('users', 'approves', 'rejects', "checkEmailStatus", "schedules", "templates"));
    	}

	    /*student application details page*/
	    public function student($id) {
	    	/*user's id*/
			$usersId = Auth::user()->id;

			$user = UserCourses::with('user', 'detail', 'address', 'contact', 'course', 'documents')->where('companyId', $usersId)->where('id', $id)->first();

	        $checkEmailStatus = PaymentDetails::checkEmailStatus();
			$templates = SubscriberTemplates::where("usersId", $usersId)->get();

			return view('school.students.information', compact("user", "checkEmailStatus", "templates"));
	    }

	    /*schedule the student for enrollment*/
	   	public function approve(Request $request) {

	   		/*validated all the needed input for email*/
	   		$attributes = request()->validate([
	   			'course_name'=> ['required', 'max:255'],
	   			'name-modal'=> ['required', 'max:255'],
	   			'email-modal'=> ['required', 'max:255'],
	   			'id-modal'=> ['required', 'max:255'],
	   			'date'=> ['required', 'date_format:Y-m-d H:i:s'],
	   		]);

	   		DB::beginTransaction();
	   		try {
	   			$id 	= $request->input('id-modal');
	   			$date 	= $request->input('date');

	   			/*update the status of the application into scheduled or approve*/
	   		    $course 				= UserCourses::find($id);
	   		    $course->status 		= 2;
	   		    $course->isActive 		= 1;
	   		    $course->schedule_date 	= $date;

	   		    $lastInsertedID = $course->id;
	   		    /*scheduled date given by school*/
	   		    $schedule_date 	= date('F d, Y', strtotime($date));
	   		   
	   		    $hour 			= date("H",strtotime($date));
	   		    $minute 		= date("i",strtotime($date));
	   		    
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
				
				/*receiver info*/
				$receiver_email = $request->input('email-modal'); //email
				$receiver_name 	= $request->input('name-modal');	//name
				$course_name 	= $request->input('course_name');	//name

				/*id of the template that will use*/
				$templateId = $request->input("subject");

				$subject 	= $request->input("asubject");
				$message 	= $request->input("amessage");

				if($templateId) {
					/*get template details*/
					$template 	= SubscriberTemplates::find($templateId);
					$template->message = $message;
					$template->subject = $subject;
					$template->save();
				}
				else {
					$usersId = Auth::user()->id;
		        	/*create new template*/
					$template 			= new SubscriberTemplates();
					$template->usersId 	= $usersId;
					/*subject of the email*/
					$template->subject 	= $subject;
					/*content of the email*/
					$template->message 	= $message;
					$template->save();
				}

				/*put the schedule date into the template message*/
				$message  	= str_replace("[application_date]",$schedule_date,$message);

				/*put the schedule time into the template message*/
				$message  	= str_replace("[application_time]",$schedule_time,$message);

				/*put the course that the users applied for into the template message*/
				$message  	= str_replace("[application_name]",$course_name,$message);
				$subject  	= str_replace("[application_name]",$course_name,$subject);

				$course->message 	= $message;
				$course->save();	

				$parameters = array("courseApplicationId" => $course->id);

				$response 			= UserCourseResponse::firstOrNew($parameters);
				$response->usersId 	= $course->usersId;
				$response->courseApplicationId 	= $course->id;
				$response->isAccept 			= 3;
				$response->save();

				$actions = "Please check your profile <a href='".url('applicant/courses/'.$id)."'>here</a> to response.";

				/*parameters for sending email*/
				$emailArray = array("receiver_email" 	=> $receiver_email,
									"receiver_name" 	=> $receiver_name,
									"message"	=> $message,
									"subject" 	=> $subject,
									"actions" 	=> $actions);
	 
				/*send the email*/
				EmailModel::sendEmail($emailArray);

	   		    DB::commit();
	   		} 

	   		catch (\Exception $ex) {
	   		    DB::rollback();
	   		    return response()->json(['error' => $ex->getMessage()], 500);
	   		}
	       	
	        alert()->success("SUCCESSFULLY INVITED", '');
	       	return Redirect::back();
	    }

	    public function reject(Request $request) {
	   		DB::beginTransaction();
	   		try {
	   			/*validate all inputs*/
	   			$validator = Validator::make($request->all(), [
	   			    'course_name'	  => 'required|max:255',
	   			    'applicant_name'  => 'required|max:255',
	   			    'applicant_email' => 'required|max:255',
	   			    'application_id'  => 'required|exists:user_courses_application,id',
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
		   			$id = $request->input('application_id');

		   			/*change the application of the user into rejected*/
		   		    $course 				= UserCourses::find($id);
		   		    $course->status 		= 0;
		   		    $course->isActive 		= 1;
		   		    $course->save();

		   		    /*receiver info*/
					$receiver_email = $request->input('applicant_email'); //email
					$receiver_name 	= $request->input('applicant_name');	//name
					$course_name 	= $request->input('course_name');	//name

					/*get id of the template that will use*/
					$templateId = $request->input("template_id");

					$subject 	= $request->input("dsubject");
					$message 	= $request->input("dmessage");

					if($templateId) {
						/*get template details*/
						$template 	= SubscriberTemplates::find($templateId);
						$template->message = $message;
						$template->subject = $subject;
						$template->save();
					}
					else {
						$usersId = Auth::user()->id;
			        	/*create new template*/
						$template 			= new SubscriberTemplates();
						$template->usersId 	= $usersId;
						/*subject of the email*/
						$template->subject 	= $subject;
						/*content of the email*/
						$template->message 	= $message;
						$template->save();
					}

					$subject  	= str_replace("[application_name]",$course_name,$subject);
					/*put the course that the users applied for into the template message*/
					$message  	= str_replace("[application_name]",$course_name,$message);

					$actions = "Please check your profile <a href='".url('applicant/courses/'.$id)."'>here</a> for details.";

					/*parameters for sending email*/
					$emailArray = array("receiver_email" 	=> $receiver_email,
										"receiver_name" 	=> $receiver_name,
										"message"			=> $message,
										"subject" 			=> $subject,
										"actions" 			=> $actions);
					
					/*send the email*/
					EmailModel::sendEmail($emailArray);

		   		    DB::commit();

		       		$result_msg = "SUCCESSFULLY REJECTED";

		       		return response()->json(['result' => true, "message" => $result_msg]);
		       	}
	   		} 

	   		catch (\Exception $ex) {
	   		    DB::rollback();
	   		    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
	   		}
	    }

	    /*schedule the student for enrollment*/
	   	public function approve2(Request $request) {

	   		/*validated all the needed input for email*/
	   		$attributes = request()->validate([
	   			'course_name'=> ['required', 'max:255'],
	   			'name-modal'=> ['required', 'max:255'],
	   			'email-modal'=> ['required', 'max:255'],
	   			'id-modal'=> ['required', 'max:255']
	   		]);

	   		DB::beginTransaction();
	   		try {
	   			$id 	= $request->input('id-modal');
	   			$date 	= $request->input('date');

	   			/*update the status of the application into scheduled or approve*/
	   		    $course 				= UserCourses::find($id);
	   		    $course->status 		= 2;
	   		    $course->isActive 		= 1;
	   		    $course->save();

	   		    $lastInsertedID = $course->id;
	   		    $resp = UserCourseResponse::where("courseApplicationId", $lastInsertedID)->delete();

				/*receiver info*/
				$receiver_email = $request->input('email-modal'); //email
				$receiver_name 	= $request->input('name-modal');	//name
				$course_name 	= $request->input('course_name');	//name

				$subject 		= "Application Approved";
				$message 		= "You have been approved to ". $course_name;

				$actions = "Please check your profile <a href='".url('applicant/courses/'.$id)."'>here</a> for details.";

				/*parameters for sending email*/
				$emailArray = array("receiver_email" 	=> $receiver_email,
									"receiver_name" 	=> $receiver_name,
									"message"	=> $message,
									"subject" 	=> $subject,
									"actions" 	=> $actions);
	 
				/*send the email*/
				EmailModel::sendEmail($emailArray);

	   		    DB::commit();
	   		} 

	   		catch (\Exception $ex) {
	   		    DB::rollback();
	   		    return response()->json(['error' => $ex->getMessage()], 500);
	   		}
	       	
	        alert()->success("SUCCESSFULLY INVITED", '');
	       	return Redirect::back();
	    }

	    public function reject2(Request $request) {
	   		DB::beginTransaction();
	   		try {
	   			/*validate all inputs*/
	            $validator = Validator::make($request->all(), [
	                'course_name'     => 'required|max:255',
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
		   			$id = $request->input('application_id');

		   			/*change the application of the user into rejected*/
		   		    $course 				= UserCourses::find($id);
		   		    $course->status 		= 0;
		   		    $course->isActive 		= 1;
		   		    $course->save();

		   		    /*receiver info*/
					$receiver_email = $request->input('applicant_email'); //email
					$receiver_name 	= $request->input('applicant_name');	//name
					$course_name 	= $request->input('course_name');	//name

					$subject = "Application Rejected";
					$message = "You have been rejected to " . $course_name;

					$actions = "Please check your profile <a href='".url('applicant/courses/'.$id)."'>here</a> for details.";

					/*parameters for sending email*/
					$emailArray = array("receiver_email" 	=> $receiver_email,
										"receiver_name" 	=> $receiver_name,
										"message"			=> $message,
										"subject" 			=> $subject,
										"actions" 			=> $actions);
					
					/*send the email*/
					EmailModel::sendEmail($emailArray);

		   		    DB::commit();

		       		$result_msg = "SUCCESSFULLY REJECTED";

		       		return response()->json(['result' => true, "message"=> $result_msg]);
		       	}
	   		} 

	   		catch (\Exception $ex) {
	   		    DB::rollback();
	   		    return response()->json(['result' => false, 'message' => $ex->getMessage()]);
	   		}
	    }

	    public function applicationsByType($type, $id) {
	        $usersId          = Auth::user()->id;

	        if($type==="unprocessed") {
	            $status = 1;
	        }
	        else if($type==="interview") {
	            $status = 2;
	        }
	        else {
	            $status = 0;
	        }

	        $applicants = UserCourses::where("courseId", $id)->where("status", $status)->where("companyId", $usersId)->paginate(10);

	        $title = SchoolCourse::where("id", $id)->first();

	        return view('school.students.summary', compact('applicants', "title"));
	    }

	    public function applications($id) {
	        $usersId          = Auth::user()->id;

	        $applicants = UserCourses::where("courseId", $id)->where("companyId", $usersId)->paginate(10);

	        $title = SchoolCourse::where("id", $id)->first();

	        return view('school.students.summary', compact('applicants',"title"));
	    }

	    public function summary() {
	        $usersId          = Auth::user()->id;

	        $applicants = UserCourses::where("companyId", $usersId)->paginate(10);
		    $countries 	= ExtraCountry::orderBy('nicename')->get();
		    $genders 	= ExtraGender::orderBy('name')->get();

	        return view('school.students.summary', compact('applicants', 'countries', 'genders'));
	    }

	    /*list of applicants who applied to this company with filter*/
	    public function search() {
	        /*user's id*/
	        $usersId  = Auth::user()->id;

	        $countries 	= ExtraCountry::orderBy('nicename')->get();
		    $genders 	= ExtraGender::orderBy('name')->get();

	        /*list of applicants who applied*/
	        $applicants = UserCourses::where("companyId", $usersId);

	        /*get filter inputs*/
			$get_gen 	= Input::get('gender');
		    $get_loc 	= Input::get('location');

	    	if (!empty($get_gen)) {
	            $applicants = $applicants->whereHas('detail', function($q) use($get_gen) {
	                   $q->where('genderId', $get_gen); 
	            });
	    	}

	    	if (!empty($get_loc)) {
	            $applicants = $applicants->whereHas('address', function($q) use($get_loc) {
	                   $q->where('countryId', $get_loc); 
	            });
	    	}

	    	$applicants = $applicants->paginate(10);

	        return view('school.students.summary', compact('applicants', 'countries', 'genders', 'get_gen', 'get_loc'));
	    }
	}
?>