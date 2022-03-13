<?php

    namespace App\Http\Controllers\Student;

    use DB;
    use Auth;
    use File;
    use Alert;
    use Crypt;
    use Helper;
    use Redirect;
    use Carbon\Carbon;
    use App\MaintenanceLocale;
    use App\User;
    use App\UserCourses;
    use App\EmailModel;
    use App\SchoolCourse;
    use App\Jobs\SendEmailJob;
    use App\UserCourseResponse;
    use App\UserCourseBookmark;
    use App\SubscriberAffilation;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Validator;

    class CourseController extends Controller {
        	
        /*list of courses application*/
        public function index() {
            $id 	= Auth::user()->id;

        	$courses = UserCourses::with("school", "course", "response", "company_documents")->where("usersId", $id)->where('status', '2')->whereNotNull("schedule_date")->whereHas('response')->orderBy('id', 'desc')->paginate(10);

            $approves = UserCourses::with("school", "course", "response", "company_documents")->where("usersId", $id)->where('status', '2')->whereNull("schedule_date")->doesntHave('response')->orderBy('id', 'desc')->paginate(10);

            $pending = UserCourses::with("school", "course", "response", "company_documents")->where("usersId", $id)->where('status', '1')->whereNull("schedule_date")->doesntHave('response')->orderBy('id', 'desc')->paginate(10);

            $rejects = UserCourses::with("school", "course", "response", "company_documents")->where("usersId", $id)->where('status', '0')->whereNull("schedule_date")->doesntHave('response')->orderBy('id', 'desc')->paginate(10);
    		
    		return view('student.courses.index', compact("courses", "approves", "pending", "rejects"));
        }

        public function courses() {
            $id 		= Auth::user()->id;
            $courses 	= UserCourseBookmark::where("usersId", $id)->paginate(10);

    		return view('student.courses.saved', compact("courses"));
        }

        public function show($id) {
        	$profile = UserCourses::with("school", "course", "response", "company_documents")->where("id", $id)->first();

    		return view('student.courses.information', compact("profile"));
        }

        /*apply to this course*/
        public function store(Request $request) {
            DB::beginTransaction();
            try {    
                $id 			= Auth::user()->id;

                /*course id*/
                $courseId 		= $request->input('courseId');
            	$courseId 		= Crypt::decrypt($courseId);

            	/*company id*/
            	$companyId 		= $request->input('companyId');
            	$companyId 		= Crypt::decrypt($companyId);

            	/*birth certificate file*/
            	$file_1 		= $request->file('certificate');
                $extension_1 	= $file_1->getClientOriginalExtension();
                $contentType1   = $file_1->getMimeType();

                $fileName_1 	= time();
                $fileName_1		= $fileName_1 . "_certificate." . $extension_1; 

            	/*transcript of record file*/
            	$file_2 		= $request->file('records');
                $extension_2 	= $file_2->getClientOriginalExtension(); 
                $contentType2   = $file_2->getMimeType();

                $fileName_2 	= time();
                $fileName_2		= $fileName_2 . "_records." . $extension_2; 

                /*put file to this location*/
                $location_1 	= $id . "/documents/";

                /*move file to the said location*/
                $file_1->move(public_path()."/".$location_1, $fileName_1);
                $file_2->move(public_path()."/".$location_1, $fileName_2);

                /*create application to this course*/
                $course 			= new UserCourses();
                $course->usersId 	= $id;
                $course->courseId 	= $courseId;
                $course->companyId 	= $companyId;
                $course->path 		= $location_1;
                $course->certificate= $fileName_1;
                $course->records 	= $fileName_2;
                $course->status 	= 1;
                $course->isActive 	= 1;

                /*save to database*/
                $course->save();
                $lastInsertedId 	= $course->id;

                $school 	= User::where("id", $companyId)->first();
                $cdetail	= SchoolCourse::where("id", $courseId)->first();

                /*school email*/
                $receiver_email = $school->email;
                /*school employer name*/
                $receiver_name 	= $school->firstName . " " . $school->lastName;

                /*subject of the email*/
                $subject 		= "Application for " . $cdetail->course;
                /*content of the email*/
                $message = "You have new application for " . $cdetail->course;
    			$actions = "Please check your profile <a href='".url('school/student/'.$lastInsertedId)."'>here</a> for details.";

            	/*parameters for sending email*/
            	$emailArray = array("receiver_email" => $receiver_email,
            						"receiver_name" => $receiver_name,
            						"message" => $message,
            						"subject" => $subject,
            						"actions" => $actions);

            	/*send the email*/
            	EmailModel::sendEmail($emailArray);

                $emailArray2 = array("companyId"        => $companyId,
                                    "companyName"       => $school->school->school,
                                    "applicationName"   => $cdetail->course,
                                    "contentType"       => $contentType1,
                                    "location"          => $location_1,
                                    "pathName"          => $fileName_1,
                                    "pathName1"         => $fileName_2,
                                    "contentType1"      => $contentType2,
                                    "count"             => 2);

                EmailModel::sendAffilations($emailArray2);

                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);            
            }

            alert()->success(MaintenanceLocale::getLocale(555),'');
            return Redirect::back();
        }

        public function saved(Request $request) {
            DB::beginTransaction();
            try {    
                $id 			= Auth::user()->id;
                $key 		    = $request->input('key');
                $courseId1      = $request->input('courseId');
                $ajax 			= $request->input('ajax');
            	$courseId 		= Crypt::decrypt($courseId1);

                $user = UserCourseBookmark::where('courseId', $courseId)
                		->where("usersId", $id)->first();

                if ($user === null) {
                   	$course 			= new UserCourseBookmark();
       	            $course->usersId 	= $id;
       	            $course->courseId 	= $courseId;
               	 	$course->save();
                	$result_msg = MaintenanceLocale::getLocale(556);
                }
                else {
                	UserCourseBookmark::where("id", $user->id)->delete();
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
            	return response()->json(['result' => true, 'message' => $result_msg, 'courseId' => $key]);            
            }
            else {
            	alert()->success($result_msg,'');
            	return Redirect::back();
            }
        }

        public function response(Request $request) {
        	DB::beginTransaction();
            try {    
                $status     = $request->input('status');

                if($status==2) {
                    $validator = Validator::make($request->all(), [
                        'status'    => 'required|int',
                        'id'        => 'required|exists:user_courses_response,id',
                        'date'      => 'required|after:'.date("Y-m-d H:i:s", time()),
                    ]);
                }
                else {
                    $validator = Validator::make($request->all(), [
                        'status'    => 'required|int',
                        'id'        => 'required|exists:user_courses_response,id',
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
                    $usersId 	= Auth::user()->id;
                    $dateTime   = $request->input('date');
                	$dateTime 	= Helper::getDate($dateTime);
                	$courseApplicationId = $request->input('id');

                	$parameters 		= array("courseApplicationId" => $courseApplicationId);
                	$course 			= UserCourseResponse::firstOrNew($parameters);
                    $course->usersId 	= $usersId;
                    $course->courseApplicationId = $courseApplicationId;
                    $course->isAccept 		= $status;

                	if($status==2) {
                		$availability = $request->input('date');
                    	$course->availability 	= $availability;
                	}

               	 	$course->save();

               	 	if($course->save()) {
        		     	$firstName 		= ucfirst(Auth::user()->firstName);
        		     	$lastName 		= ucfirst(Auth::user()->lastName);
        	 			
        	 			$course 	= UserCourses::with("users")->where("id", $courseApplicationId)->first();

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

               	 		if(!empty($course)) {
        	       	 		$subject 		= $firstName . " " . $lastName . " responded to your invitation.";
               	 			$receiver_name 	= $course->users->firstName ." ".$course->users->lastName;
        					$actions = "Please check your profile <a href='".url('school/student/'.$courseApplicationId)."'>here</a> for details.";

               	 			/*parameters for sending email*/
               	 			$emailArray = array("receiver_email" 	=> $course->users->email,
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
    }
