<?php

	namespace App\Http\Controllers\Front;

	use DB;
	use Auth;
	use Crypt;
	use Carbon\Carbon;

	use App\User;
	use App\UserDetail;
	use App\UserAddress;
	use App\UserContact;
	use App\EmployerJob;
	use App\UserDocument;
	use App\ExtraCountry;
	use App\UserBookmark;
	use App\ExtraCurrency;
	use App\ExtraEmployment;
	use App\UserApplication;
	use App\ExtraSpecialization;
	use App\SubscriptionDetails;
	use App\SubscriberAffilation;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Contracts\Encryption\DecryptException;

	class JobsController extends Controller {

		public function index() {   
		    $now    = Carbon::now()->format('Y-m-d');
		    $saves_ = array();
		    $search = false;

		    $country        = ExtraCountry::orderBy('nicename')->get();
		    $employment     = ExtraEmployment::orderBy('name')->get();
		    $currencies     = ExtraCurrency::orderBy('name')->get();
		    $specialization = ExtraSpecialization::orderBy('name')->get();

		    /*get courses not deleted*/
		    $jobs = EmployerJob::where("isDeleted", 0)->where("isActive", 1)->where("isValidate", 1)->where('last_day', '>', $now)->whereHas('employers', function($q) use($now) {
		            $q->join('subscriber_details', "subscriber_details.usersId", '=', "employer_details.usersId")->where(function($r) use($now) {
		                    $r->where('subscriber_details.last_day', '>', $now)->orWhere('subscriber_details.last_day', null);
		                }); 
		        })->orderBy('id', 'desc')->paginate(10);

		    if(Auth::check()) {
		    	$userId = Auth::user()->id;
		    	$saves 	= UserBookmark::where("usersId", $userId)->get();

		    	$saves_ = array();
		    	foreach ($saves as $save) {
		    		array_push($saves_, $save->jobId);
		    	}
		    }
		  
		    return view('front.jobs', compact('saves_', 'search', 'country', 'employment', 'currencies', 'specialization', 'jobs'));
		}

		public function search() {
		    $now    = Carbon::now()->format('Y-m-d');
		    $saves_ = array();
		    $search = true;

			$country        = ExtraCountry::orderBy('nicename')->get();
			$employment     = ExtraEmployment::orderBy('name')->get();
			$currencies     = ExtraCurrency::orderBy('name')->get();
			$specialization = ExtraSpecialization::orderBy('name')->get();

		    $get_spe 	= Input::get('specialization');
		    $get_emp 	= Input::get('employment');
		    $get_loc 	= Input::get('location');
		    $get_curr 	= Input::get('currency');
		    $get_title 	= Input::get('title');
		    $get_salary = Input::get('salary');
		    $get_salary = (int)$get_salary;

		    if(Auth::check()) {
		    	$userId = Auth::user()->id;
		    	$saves 	= UserBookmark::where("usersId", $userId)->get();

		    	$saves_ = array();
		    	foreach ($saves as $save) {
		    		array_push($saves_, $save->jobId);
		    	}
		    }

		    $jobs = EmployerJob::where("isDeleted", 0)->where("isActive", 1)->where("isValidate", 1)->where('last_day', '>', $now)->whereHas('employers', function($q) use($now) {
		            $q->join('subscriber_details', "subscriber_details.usersId", '=', "employer_details.usersId")->where(function($r) use($now) {
		                    $r->where('subscriber_details.last_day', '>', $now)->orWhere('subscriber_details.last_day', null);
		                }); 
		        });

		    if (!empty($get_spe)) {
		        $jobs = $jobs->where('specializationId', $get_spe);
		    }

		    if (!empty($get_emp)) {
		        $jobs = $jobs->where('employmentId', $get_emp);
		    }
		    
		    if (!empty($get_loc)) {
		        $jobs = $jobs->where('locationId', $get_loc);
		    }
		    
		    if (!empty($get_title)) {
		        $jobs = $jobs->where('title', 'like', '%'.$get_title.'%');
		    }
		    
		    if (!empty($get_curr)) {
		        $jobs = $jobs->where('currencyId', $get_curr);
		    }

		    if (!empty($get_salary)) {
		        $jobs = $jobs->where(function($q) use($get_salary) {
					        $q->where('min', '<=', $get_salary)->where('max', ">=", $get_salary);
					    });
		    }

			$jobs = $jobs->orderBy('id', 'desc')->paginate(10);

		    return view('front.jobs', compact('saves_', 'search', 'country', 'employment', 'currencies', 'specialization', 'get_spe', 'get_emp', 'get_loc', 'get_curr', 'get_title', 'get_salary', 'jobs'));
		}

	    /*job details page*/
	    public function show($id) {
	    	try {
		    	$id  = Crypt::decrypt($id);
				$now = Carbon::now()->format('Y-m-d');

		       	/*check if job is deleted*/
		        $job 			= EmployerJob::where('id', $id)->first();
		        $isDeleted 		= EmployerJob::where('id', $id)->where("isDeleted", 1)->first();

		        if(!$isDeleted) {
		        	$isValidated = EmployerJob::where('id', $id)->where("isValidate", 1)->first();

		        	if($isValidated) {
  		        		$isActive = EmployerJob::where('id', $id)->where("isActive", 1)->first();

  		        		if($isActive) {
		        			$isExpired = EmployerJob::where('id', $id)->where('last_day', '<', $now)->first();

		        			if(!$isExpired) {
								$jobStatus 			= true;
			        			$organizationIds 	= $job->usersId;
	  							$organizationId 	= Crypt::encrypt($organizationIds);

	  							$isEndedSubscription = SubscriptionDetails::where('usersId', $organizationIds)->orderBy('id', 'DESC')->where(function($q) use($now) {
					                    $q->where('last_day', '<', $now)->whereNotNull('last_day');
					                })->first();
	        					
	        					$affilations = SubscriberAffilation::where('isActive', 1)->where(function($q) use($organizationIds) {
	  							        $q->where('companyId', $organizationIds)->orWhere('usersId', $organizationIds);
	  							    })->get();

								if(!$isEndedSubscription) {
									if(Auth::check()) {
								    	$detailsStatus 	= false;
								    	$profileStatus 	= false;
								    	$resumeStatus 	= false;
								    	$applied 		= false;
								    	$usersId 		= Auth::user()->id;

								    	$bookMarkStatus = UserBookmark::where('usersId', $usersId)->where("jobId", $id)->count();

								    	/*check if user has application to this job*/
								    	$applied 	= UserApplication::where('usersId', $usersId)->where('jobId', $id)->where('isActive', 1)->count();

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

								    	$usersImage = UserDocument::where('usersId', $usersId)->where('filetype', 'profile')->count();
								    	$usersResume = UserDocument::where('usersId', $usersId)->where('filetype', 'resume')->count();

										if($usersImage>0) {
								    		$profileStatus 	= true;
										}

										if($usersResume>0) {
								    		$resumeStatus 	= true;
										}

								    	/*if users profile is not complete don't allow her/him to apply*/
								    	if($usersDB>0 || $usersDetailsDB>0 || $usersAddressDB>0 || $usersContactDB>0) {
								    		$detailsStatus = true;
								    	}
									}
								   	/*if user is not login he/she can't apply to this job*/
									else {
								    	$applied 		= false;
								    	$resumeStatus 	= false;
								    	$detailsStatus 	= false;
								    	$profileStatus 	= false;
								    	$jobStatus 		= false;
								    	$bookMarkStatus = false;
									}
									return view('front.job', compact('job', 'applied', "detailsStatus", "jobStatus", 'bookMarkStatus', 'profileStatus', 'affilations', 'resumeStatus'));
								}
								else {
									alert()->error('JOB IS ALREADY DELETED!');
									return redirect('jobs');
								}
		        			}
		        			else {
		        				alert()->error('JOB IS ALREADY EXPIRED!');
		        				return redirect('jobs');
		        			}
  		        		}
  		        		else {
  		        			alert()->error('JOB IS ALREADY CLOSED!');
  		        			return redirect('jobs');
  		        		}
		        	}
		        	else {
		        		alert()->error('JOB IS ON PROCESS!');
		        		return redirect('jobs');
		        	}
		        }
		        else {
		        	alert()->error('JOB IS ALREADY DELETED!');
		        	return redirect('jobs');
		        }
			}

			catch (DecryptException $e) {
	        	return redirect('/jobs');
	    	}
	    }
	}
?>
