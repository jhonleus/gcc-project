<?php

    namespace App\Http\Controllers\Organization;

    use DB;
    use Auth;
    use \Carbon\Carbon;

    use App\User;
    use App\EmailModel;
    use App\EmployerJob;
    use App\UserDocument;
    use App\ExtraCountry;
    use App\ExtraCurrency;
    use App\ExtraIndustry;
    use App\UserInvitation;
    use App\ExtraEmployment;
    use App\EmployerBookmark;
    use App\UserCertification;
    use App\SubscriptionDetails;
    use App\ExtraSpecialization;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Validator;

    class CompanyController extends Controller {

        /*list of applicants*/
        public function index() {

            /*user's id*/
            $usersId = Auth::user()->id;
            /*date today*/
            $now = Carbon::now()->format('Y-m-d');
            $search = false;

            $country 		= ExtraCountry::orderBy('nicename')->get();
            $industries     = ExtraIndustry::orderBy('name')->get();

            $users = User::whereHas('employerdetails')->where("rolesId", 2)->paginate(10);

    		return view('organization.companies.index', compact('search', 'country', 'industries', 'users'));
        }

        public function search() {
            /*user's id*/
            $usersId = Auth::user()->id;
            /*date today*/
            $now = Carbon::now()->format('Y-m-d');
            $search = true;

            $saves = EmployerBookmark::where("usersId", $usersId)->get();
            $saves_ = array();
            foreach ($saves as $save) {
                array_push($saves_, $save->applicantId);
            }

            if (isset($_POST['clear_filter'])) {

                $get_loc = "";
                $get_ind = "";

            }

            else {

               /*get filter inputs*/
               $get_loc    = Input::get('location');
               $get_ind    = Input::get('industry');

            }

            $users = User::query()->whereHas('employerdetails')->where("rolesId", 2);

            if (!empty($get_ind)) {
                $users =    $users->where(function($q) use($get_ind) {
                                $q->whereHas('employerdetails', function($r) use($get_ind) {
                                    $r->where('industryId', $get_ind);
                                });
                            });
            }

            if (!empty($get_loc)) {
                $users = $users->where(function($q) use($get_loc) {
                            $q->WhereHas('address', function($s) use($get_loc) {
                                $s->where('countryId', $get_loc); 
                            });
                        });
            }

            $users = $users->paginate(10);

            $country        = ExtraCountry::orderBy('nicename')->get();
            $industries     = ExtraIndustry::orderBy('name')->get();

            return view('organization.companies.index', compact('search', 'get_ind', 'get_loc', 'users', 'industries', 'country'));
        }
    }
?>
