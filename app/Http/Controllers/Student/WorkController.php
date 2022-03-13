<?php

    namespace App\Http\Controllers\Student;

    use DB;
    use Auth;
    use App\MaintenanceLocale;
    use App\UserWork;
    use App\ExtraCountry;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class WorkController extends Controller {

    	/*list of work experience*/
        public function index() {   
        	$usersId 	= Auth::user()->id;
            $works 	    = UserWork::where('usersId', $usersId)->orderBy('id', 'desc')->with('country')->paginate(10);

            return view('student.works.index', compact('works'));
        }
     
        public function create() {
            $countries  = ExtraCountry::orderBy('nicename')->get();

            return view('student.works.create', compact('countries'));
        }

        public function store(Request $request) {
            /*validate required fields*/
            if($request->has('date_year2')){

                $date_year = null;

                $attributes = request()->validate([
                    'country'       => 'required|exists:extra_countries,id',
                    'company'       => 'required|max:255',
                    'date_start'    => 'required|max:255',
                    'position'      => 'required|max:255',
                    'responsibly'   => 'required',
                ]);

            }

            else {

                $date_year = $request->input('date_year');

                $attributes = request()->validate([
                    'country'       => 'required|exists:extra_countries,id',
                    'company'       => 'required|max:255',
                    'date_start'    => 'required|max:255',
                    'date_year'     => 'required|max:255',
                    'position'      => 'required|max:255',
                    'responsibly'   => 'required',
                ]);

            }

            DB::beginTransaction();
            try {
                $id 	= Auth::user()->id;
                $work 	= new UserWork();
                $work->usersId 			= $id;
                $work->countryId 		= $request->input('country');
                $work->company 			= $request->input('company');
                $work->dateStart 		= $request->input('date_start');
                $work->dateEnd 			= $date_year;
                $work->position 		= $request->input('position');
                $work->jobResponsibly 	= $request->input('responsibly');
                $work->save();
        
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(257), '');
            return redirect('applicant/work_experience');
        }

      
        public function edit($id) {
            $usersId 	= Auth::user()->id;
            $countries  = ExtraCountry::orderBy('nicename')->get();
            $work 		= UserWork::where("usersId", $usersId)->where('id', $id)->first();

            return view('student.works.create', compact('countries', 'work'));
        }

        public function update(Request $request, $id) {

            if($request->has('date_year2')){

                $date_year = null;

                $attributes = request()->validate([
                    'country'       => 'required|exists:extra_countries,id',
                    'company'       => 'required|max:255',
                    'date_start'    => 'required|max:255',
                    'position'      => 'required|max:255',
                    'responsibly'   => 'required',
                ]);

            }

            else {

                $date_year = $request->input('date_year');

                $attributes = request()->validate([
                    'country'       => 'required|exists:extra_countries,id',
                    'company'       => 'required|max:255',
                    'date_start'    => 'required|max:255',
                    'date_year'     => 'required|max:255',
                    'position'      => 'required|max:255',
                    'responsibly'   => 'required',
                ]);

            }

            /*validate required fields*/
            $attributes = request()->validate([
                'country'       => 'required|exists:extra_countries,id',
                'company'       => 'required|max:255',
                'date_start'    => 'required|max:255',
                'date_year'     => 'required|max:255',
                'position'      => 'required|max:255',
                'responsibly'   => 'required',
            ]);
            
            DB::beginTransaction();
            try {
                $work = UserWork::find($id);
                $work->countryId 		= $request->input('country');
                $work->company 			= $request->input('company');
                $work->dateStart 		= $request->input('date_start');
                $work->dateEnd 			= $date_year;
                $work->position 		= $request->input('position');
                $work->jobResponsibly	= $request->input('responsibly');
                $work->save();
        
                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(258), '');
                return redirect('applicant/work_experience');
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }

        public function destroy($id) {
        	try {
                $usersId = Auth::user()->id;
            	UserWork::where('id', $id)->where('usersId', $usersId)->first()->delete();
               	
                return response()->json(['result' => true, 'message' => MaintenanceLocale::getLocale(256)]);
        	}

        	catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()]);
            }
        }
    }
?>
