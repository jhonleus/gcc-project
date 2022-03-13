<?php

	namespace App\Http\Controllers\Front;

	use DB;
	use Auth;
	use Crypt;
	use Carbon\Carbon;

	use App\User;
	use App\UserDetail;
	use App\UserCourses;
	use App\UserAddress;
	use App\UserContact;
	use App\UserDocument;
	use App\SchoolCourse;
	use App\ExtraCountry;
	use App\ExtraCurrency;
	use App\MaintenanceType;
	use App\UserCourseBookmark;
	use App\SubscriptionDetails;
	use App\SubscriberAffilation;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Contracts\Encryption\DecryptException;
	
	class CoursesController extends Controller {
	    /*list of active courses*/
	    public function index() {
			/*get all country*/
			$now 		= Carbon::now()->format('Y-m-d');
			$saves_ 	= array();
			$search 	= false;
	        $countries	= ExtraCountry::orderBy('nicename')->get();
	        $currencies	= ExtraCurrency::orderBy('name')->get();
	        $types 		= MaintenanceType::orderBy('name')->where("roleId", 4)->get();

		    /*get courses not deleted*/
		    $courses = SchoolCourse::where("isDeleted", 0)->where("isActive", 1)->where('last_day', '>', $now)->whereHas('employers', function($q) use($now) {
	    		            $q->join('subscriber_details', "subscriber_details.usersId", '=', "school_details.usersId")->where(function($r) use($now) {
	    		                    $r->where('subscriber_details.last_day', '>', $now)->orWhere('subscriber_details.last_day', null);
	    		                }); 
	    		        })->orderBy('id', 'desc')->paginate(10);


							
			if(Auth::check()) {
				$userId = Auth::user()->id;
				$saves 	= UserCourseBookmark::where("usersId", $userId)->get();

				$saves_ = array();
				foreach ($saves as $save) {
					array_push($saves_, $save->courseId);
				}
			}

			return view('front.courses', compact('search', 'countries', 'courses', 'currencies', 'saves_', 'types'));
	    }

	    /*search courses*/
	    public function search() {
			$now 		= Carbon::now()->format('Y-m-d');
			$search 	= true;
	        $saves_ 	= array();
	        $countries	= ExtraCountry::orderBy('nicename')->get();
	        $currencies	= ExtraCurrency::orderBy('name')->get();
	        $types 		= MaintenanceType::orderBy('name')->where("roleId", 4)->get();

	        if(Auth::check()) {
	        	$userId = Auth::user()->id;
	        	$saves 	= UserCourseBookmark::where("usersId", $userId)->get();

	        	$saves_ = array();
	        	foreach ($saves as $save) {
	        		array_push($saves_, $save->courseId);
	        	}
	        }

	        /*input request*/
	        $get_type 		= Input::get('type');
	        $get_loc 		= Input::get('country');
	        $get_cour 		= Input::get('course');
	        $get_curr 		= Input::get('currency');
	        $get_salary 	= Input::get('salary');
	        $get_school 	= Input::get('school');
	        $get_salary 	= (int)$get_salary;

	    	/*get list of courses*/
	    	$courses = SchoolCourse::where("isDeleted", 0)->where("isActive", 1)->where('last_day', '>', $now)->whereHas('employers', function($q) use($now) {
	    		            $q->join('subscriber_details', "subscriber_details.usersId", '=', "school_details.usersId")->where(function($r) use($now) {
	    		                    $r->where('subscriber_details.last_day', '>', $now)->orWhere('subscriber_details.last_day', null);
	    		                }); 
	    		        });

	    	if (!empty($get_type)) {
	    	    $courses = $courses->whereHas('employers', function($q) use($get_type) {
	                   $q->where('typeId', $get_type); 
	            });
	    	}

			/*if country is not empty find courses in that country*/
			if (!empty($get_loc)) {
				$courses = $courses->where('locationId', $get_loc);
			}

			/*if title is not empty find courses that fit on the keywords*/
			if (!empty($get_cour)) {
				$courses = $courses->where('course', 'like', '%'.$get_cour.'%');
			}

			if (!empty($get_school)) {
	    	    $courses = $courses->whereHas('employers', function($q) use($get_school) {
	               	$q->where('school', 'like', '%'.$get_school.'%'); 
	            });
	    	}

			if (!empty($get_curr)) {
			    $courses = $courses->where('currencyId', $get_curr);
			}

			if (!empty($get_salary)) {
			    $courses = $courses->where(function($q) use($get_salary) {
					        $q->where('fee', '<=', $get_salary)->where('fee', ">=", $get_salary);
					    });
			}

			$courses = $courses->orderBy('id', 'desc')->paginate(10);

			return view('front.courses', compact('search', 'get_loc', 'get_cour', 'countries', 'courses', 'get_curr', 'get_school', 'get_salary', 'get_type', 'currencies', 'types', 'saves_'));
		}

	    /*course details page*/
	    public function show($id) {
	    	try {
		  		$id 	= Crypt::decrypt($id);
  				$now 	= Carbon::now()->format('Y-m-d');
  			   
  		        $course 		= SchoolCourse::where('id', $id)->first();
  		        $isDeleted 		= SchoolCourse::where('id', $id)->where("isDeleted", 1)->first();

  		        if(!$isDeleted) {
  		        	$isActive 		= SchoolCourse::where('id', $id)->where("isActive", 1)->first();

  		        	if($isActive) {
  		        		$isExpired = SchoolCourse::where('id', $id)->where('last_day', '<', $now)->first();

  		        		if(!$isExpired) {
  		        			$courseStatus = true;
	  						$companyIds = $course->usersId;
	  						$companyId 	= Crypt::encrypt($companyIds);

	  						$isEndedSubscription = SubscriptionDetails::where('usersId', $companyIds)->orderBy('id', 'DESC')->where(function($q) use($now) {
					                    $q->where('last_day', '<', $now)->whereNotNull('last_day');
					                })->first();

	  						if(!$isEndedSubscription) {
	  							$affilations = SubscriberAffilation::where('isActive', 1)->where(function($q) use($companyIds) {
	  							        $q->where('companyId', $companyIds)->orWhere('usersId', $companyIds);
	  							    })->get();

	  							/*if user is login*/
	  							if(Auth::check()) {
	  						    	$profileStatus 	= false;
	  						    	$detailsStatus 	= false;
	  						    	$applied 		= false;
	  						    	$usersId 		= Auth::user()->id;

	  						    	$bookMarkStatus = UserCourseBookmark::where("courseId", $id)->where("usersId", $usersId)->count();

	  						    	/*check if user has application to this course*/
	  						    	$applied = UserCourses::where('usersId', $usersId)->where("isActive", 1)->where('courseId', $id)->count();

	  						    	/*if user already applied she/he can't applied again*/
	  						    	if($applied > 0) {
	  						    		$applied = true;
	  						    	}

	  						    	/*check if userDetails are complete*/
	  						    	$usersDB 		= User::where("id", $usersId)->count();
	  						    	$usersDetailsDB = UserDetail::where("usersId", $usersId)->count();
	  						    	$usersAddressDB = UserAddress::where("usersId", $usersId)->count();
	  						    	$usersContactDB = UserContact::where("usersId", $usersId)->count();
	  						    	$usersProfileDB = UserDocument::where("usersId", $usersId)->count();

	  								if($usersProfileDB>0) {
	  						    		$profileStatus 	= true;
	  								}

	  						    	/*if users profile is not complete don't allow her/him to apply*/
	  						    	if($usersDB>0 || $usersDetailsDB>0 || $usersAddressDB>0 || $usersContactDB>0) {
	  						    		$detailsStatus = true;
	  						    	}
	  							}
	  						   	/*if user is not login he/she can't apply to this course*/
	  							else {
	  						    	$courseStatus 	= false;
	  						    	$applied 		= false;
	  						    	$detailsStatus 	= false;
	  						    	$bookMarkStatus = false;
	  						    	$profileStatus 	= false;
	  							}

								return view('front.course', compact('bookMarkStatus', 'course', 'applied', "detailsStatus", "courseStatus", "profileStatus", "affilations"));
	  						}
	  						else {
	  		        			alert()->error('COURSE IS ALREADY DELETED!');
	  		        			return redirect('courses');
	  						}
  		        		}
  		        		else {
  		        			alert()->error('COURSE IS ALREADY EXPIRED!');
  		        			return redirect('courses');
  		        		}
  		        	}
  		        	else {
  		        		alert()->error('COURSE IS ALREADY CLOSED!');
  		        		return redirect('courses');
  		        	}
  		        }
  		        else {
  		        	alert()->error('COURSE IS ALREADY DELETED!');
  		        	return redirect('courses');
  		        }
	    	}
	    	catch (DecryptException $e) {
	        	return redirect('/courses');
	    	}
	       	
	    }
	}
