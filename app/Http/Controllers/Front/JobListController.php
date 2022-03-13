<?php

namespace App\Http\Controllers\Front;
use App\CompanyLogo;
use Crypt;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExtraCurrency;
use App\ExtraCountry;
use App\ExtraEmployment;
use App\ExtraSpecialization;
use App\EmployerJob;
use App\EmployerDetail;
use App\UserApplication;
use App\User;
use App\UserDocument;
use App\UserBookmark;
use Auth;
use Session;
use URL;
use DB;
use Redirect;
use App\UserLocale;
use App\MaintenanceLocale;
use App\SubscriberRatings;

class JobListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $now =  Carbon::now()->format('Y-m-d');
        $search = false;
        $currencies = ExtraCurrency::all();
        $country = ExtraCountry::all();
        $employment = ExtraEmployment::all();
        $specialization = ExtraSpecialization::all();
        $get_spe 	= "";
        $get_emp 	= "";
        $get_loc 	= "";
        $get_title 	= "";
        $get_curr 	= "";
        $get_salary = "";

        /*get courses not deleted*/
        $jobs = EmployerJob::where("isDeleted", 0)->where("isActive", 1)->where("isValidate", 1)->whereHas('employers', function($q) use($now) {
                $q->join('subscriber_details', "subscriber_details.usersId", '=', "employer_details.usersId")->where("subscriber_details.last_day", ">", $now); 
            })->orderBy('id', 'desc')->paginate(10);

        if(Auth::check()) {
        	$userId = Auth::user()->id;
        	$saves 	= UserBookmark::where("usersId", $userId)->get();

        	$saves_ = array();
        	foreach ($saves as $save) {
        		array_push($saves_, $save->jobId);
        	}
        }
        else {
        	$saves_ = array();
        }
      
        return view('front.jobs', compact('search', 'get_salary', 'get_spe', 'get_emp', 'get_loc', 'get_title', 'get_curr', 'employment', 'jobs', 'specialization', 'currencies', 'country', 'saves_'));
    }

    public function details($encrypt) {

        $id = Crypt::decrypt($encrypt);

        $userId = "";
        if (Auth::check() == true) {
            $userId = Auth::user()->id;
        }
        
        $check = UserApplication::where('jobId',$id)->first();
       
        $jobs = EmployerJob::where('id', $id)->first();
        $resume = UserDocument::where('usersId', $userId)->where('filetype', 'resume')->first();
        $bookmarks = UserBookmark::where('usersId', $userId)->get();
    
        return view('jobs.view_details', compact('check', 'resume', 'bookmarks', 'jobs'));
    }

    public function search() {

        $search = true;
        $get_spe 	= Input::get('specialization');
        $get_emp 	= Input::get('employment');
        $get_loc 	= Input::get('location');
        $get_title 	= Input::get('title');
        $get_curr 	= Input::get('currency');
        $get_salary = Input::get('salary');

        $jobs = EmployerJob::query();

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
            $jobs = $jobs->where('min', '<=', $get_salary);
        }

        $jobs = $jobs->where('isActive', 1)->where("isDeleted", 0)->paginate(10);

        $employment = ExtraEmployment::all();
        $currencies = ExtraCurrency::all();
        $country = ExtraCountry::all();
        $specialization = ExtraSpecialization::all();

        //$jobs = EmployerJob::orderBy('id', 'desc')->where('isActive', '1')->get();

        return view('front.jobs', compact('search', 'get_salary', 'get_spe', 'get_emp', 'get_loc', 'get_title', 'get_curr', 'employment', 'jobs', 'specialization', 'currencies', 'country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has($request['btnBook'])) {

            DB::beginTransaction();
            try {    
                $id = Auth::user()->id;

                $bookmark = UserBookmark::firstOrNew(array('usersId' => $id));
                $bookmark->usersId = $id;
                $bookmark->jobId = $request->input('jobId');
                $bookmark->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);            
            }

            alert()->success('Successfully Bookmarked','');
            return Redirect::back();

        } else if ($request->has($request['btnUnBook'])) {

            DB::beginTransaction();
            try {    
                $id = Auth::user()->id;
                $jobId = $request->input('jobId');

                $bookmark = UserBookmark::where('usersId', $id)->where('jobId', $jobId);
                $bookmark->delete();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);            
            }

            alert()->success('Successfully Un-Bookmarked','');
            return Redirect::back();

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
