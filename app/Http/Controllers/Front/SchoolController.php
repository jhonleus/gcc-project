<?php
	namespace App\Http\Controllers\Front;

	use DB;
	use Crypt;
	use Carbon\Carbon;

	use App\SchoolDetail;
	use App\SchoolCourse;
	use App\MaintenanceBlog;
	use App\SubscriberReviews;
	use App\SubscriberRatings;
	use App\SubscriberAffilation;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
    use Illuminate\Contracts\Encryption\DecryptException;

	class SchoolController extends Controller {
		/*get the information of the company by id*/
		public function index($encrypt) {
            try {
				/*school id encrypted*/
				$now = Carbon::now()->format('Y-m-d');
			    $usersId    = Crypt::decrypt($encrypt);
			    $companyId  = $usersId;

			    /*get school details*/
			    $school = SchoolDetail::with("address", 'files')->where("usersId", $usersId)->first();

			    /*get courses not deleted*/
			    $courses = SchoolCourse::where("usersId", $usersId)->where("isDeleted", 0)->where("isActive", 1)->whereHas('employers', function($q) use($now) {
		            	$q->join('subscriber_details', "subscriber_details.usersId", '=', "school_details.usersId")->where("subscriber_details.last_day", ">", $now); 
		            })->orderBy('id', 'desc')->paginate(10);

			    /*get reviews of this school*/
			   	$reviews = SubscriberReviews::where("companyId", $usersId)->where("isActive", 1)->get();

			    /*get ratings of this school*/
			   	$ratings = SubscriberRatings::where("companyId", $usersId)->select(DB::raw('round(AVG(fees),0) as fees, round(AVG(career_growth),0) as career_growth, round(AVG(security),0) as security, round(AVG(relation),0) as relation, round(AVG(environment),0) as environment, round(AVG(overall),2) as overall'))->groupBy('companyId')->first();

			    $affilations = SubscriberAffilation::where('isActive', 1)->where(function($q) use($usersId) {
			            $q->where('companyId', $usersId)->orWhere('usersId', $usersId);
			        })->paginate(10);

			    $blogs = MaintenanceBlog::where('usersId', $usersId)->where("status", 1)->paginate(10);

			  	return view('front.school', compact('companyId', 'school', 'courses', 'reviews', 'ratings', 'affilations', 'blogs'));
			}

			catch (DecryptException $e) {
			    alert()->error('SCHOOL IS NOT EXISTING!');
			    return redirect('courses');
			}
		}
	}
?>	