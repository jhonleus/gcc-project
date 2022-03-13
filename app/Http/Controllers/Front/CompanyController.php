<?php

    namespace App\Http\Controllers\Front;

    use DB;
    use Crypt;
    use Carbon\Carbon;

    use App\User;
    use App\EmployerJob;
    use App\EmployerDetail;
    use App\MaintenanceBlog;
    use App\SubscriberReviews;
    use App\SubscriberRatings;
    use App\SubscriberAffilation;
    use App\Http\Controllers\Controller;
    use Auth;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Contracts\Encryption\DecryptException;

    class CompanyController extends Controller {

        /*get the information of the company by id*/
        public function index($encrypt) {
            try {
                $now =  Carbon::now()->format('Y-m-d');
                $usersId    = Crypt::decrypt($encrypt);
                $companyId  = $usersId;

                /*get organization details*/
                $organization = EmployerDetail::with("address", "files", 'user')->where("usersId", $usersId)->first();

                if (!$organization) {
                    $user = User::findOrfail($companyId);
                    $companyname = $user->firstName;
                }else{
                    $companyname = '';
                }


                $users  = User::find($usersId)->first();

                $jobs = EmployerJob::where('usersId', $usersId)->where("isDeleted", 0)->where("isActive", 1)->where("isValidate", 1)->whereHas('employers', function($q) use($now) {
                        $q->join('subscriber_details', "subscriber_details.usersId", '=', "employer_details.usersId")->where("subscriber_details.last_day", ">", $now)->orWhere('subscriber_details.last_day', null);
                    })->orderBy('id', 'desc')->paginate(10);

                /*get reviews of this organization*/
                $reviews = SubscriberReviews::where("companyId", $usersId)->where("isActive", 1)->get();

                /*get ratings of this organization*/
                $ratings = SubscriberRatings::where("companyId", $usersId)->select(DB::raw('round(AVG(fees),0) as fees, round(AVG(career_growth),0) as career_growth, round(AVG(security),0) as security, round(AVG(relation),0) as relation, round(AVG(environment),0) as environment, round(AVG(overall),2) as overall'))->groupBy('companyId')->first();

                $affilations = SubscriberAffilation::where('isActive', 1)->where(function($q) use($usersId) {
                        $q->where('companyId', $usersId)->orWhere('usersId', $usersId);
                    })->paginate(10);

                $blogs = MaintenanceBlog::where('usersId', $usersId)->where("status", 1)->paginate(10);

                return view('front.company', compact('companyId', 'organization', 'users', 'jobs', 'reviews', 'ratings', 'affilations', 'blogs', 'companyname'));
            }

            catch (DecryptException $e) {
                alert()->error('COMPANY IS NOT EXISTING!');
                return redirect('companies');
            }
        }

        /*list of companies desc by average*/
        public function companies() {
            /* get all employer join users and rating */
        	$ratings 	= SubscriberRatings::select("companyId", DB::raw('AVG(overall) as average, AVG(career_growth) as career_growth, AVG(security) as security, AVG(relation) as relation, AVG(environment) as environment, AVG(fees) as fees'))->groupBy("companyId")->get()->keyBy('companyId');

            /*$companies 	=   EmployerDetail::with("files")->whereHas('user', function($q) {
                                $q->where('rolesId', 3);
                            })->paginate(6);*/
            $companies = User::whereIn("rolesId", [3,2])->paginate(6);

            $sortn = null;
            $sortr = null;

            return view('front.companies', compact('ratings', 'companies', 'sortn', 'sortr'));
        }

        public function sortn($sortn) {
            /* get all employer join users and rating */
        	$ratings 	= SubscriberRatings::select("companyId", DB::raw('AVG(overall) as average, AVG(career_growth) as career_growth, AVG(security) as security, AVG(relation) as relation, AVG(environment) as environment, AVG(fees) as fees'))->groupBy("companyId")->get()->keyBy('companyId');

        	$companies 	= EmployerDetail::with("files")->whereHas('user', function($q) {
                        $q->where('rolesId', 3);
                    })->orderBy('company', $sortn)->paginate(6);

            $sortr = null;

            return view('front.companies', compact('ratings', 'companies', 'sortn', 'sortr'));
        }

        public function sortr($sortr) {
            if ($sortr == "highest") {
                $sortr = "asc";
            }
            else if ($sortr == "lowest") {
                $sortr = "desc";
            }

            /* get all employer join users and rating */
        	$ratings = SubscriberRatings::select("companyId", DB::raw('AVG(overall) as average, AVG(career_growth) as career_growth, AVG(security) as security, AVG(relation) as relation, AVG(environment) as environment, AVG(fees) as fees'))->groupBy("companyId")->orderBy('average', $sortr)->get()->keyBy('companyId');

        	$companies 	= EmployerDetail::with("files")->whereHas('user', function($q) {
                        $q->where('rolesId', 3);
                    })->orderBy('company', $sortr)->paginate(6);

            $sortn = null;

            return view('front.companies', compact('sortr', 'sortn', 'ratings', 'companies'));
        }
    }
?>
