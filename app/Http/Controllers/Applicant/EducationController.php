<?php

    namespace App\Http\Controllers\Applicant;

    use DB;
    use Auth;
    use App\MaintenanceLocale;
    use App\User;
    use App\ExtraLevel;
    use App\ExtraCountry;
    use App\UserEducation;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class EducationController extends Controller
    {
        public function index() {   
            $id = Auth::user()->id;
            $educations = UserEducation::where('usersId', $id)->with('levels', 'country')->orderBy('id', 'desc')->paginate(10);
     
            return view('applicant.educations.index', compact('educations'));
        }
     
        public function create() {   
            $levels     = ExtraLevel::orderBy('name')->get();
            $countries  = ExtraCountry::orderBy('nicename')->get();
     
            return view('applicant.educations.create', compact('levels', 'countries'));
        }

        public function store(Request $request) {
            /*validate required fields*/
            $attributes = request()->validate([
                'level'         => 'required|exists:extra_levels,id',
                'country'       => 'required|exists:extra_countries,id',
                'school'        => 'required|max:255',
                'date_start'    => 'required|max:255',
                'date_year'     => 'required|max:255',
                'attainment'    => 'required|max:255',
            ]);

            DB::beginTransaction();
            try {
                $usersId 		= Auth::user()->id;
                $education 	    = new UserEducation();
                $education->levelId 	= $request->input('level');
                $education->usersId 	= $usersId;
                $education->countryId 	= $request->input('country');
                $education->name 		= $request->input('school');
                $education->dateStart 	= $request->input('date_start');
                $education->dateEnd 	= $request->input('date_year');
                $education->attainment  = $request->input('attainment');
                $education->save();
        
                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(257), '');
            return redirect('applicant/education');
        }

        public function edit($id) {   
            $usersId 	= Auth::user()->id;
            $levels     = ExtraLevel::orderBy('name')->get();
            $countries  = ExtraCountry::orderBy('nicename')->get();
            $education 	= UserEducation::where('id', $id)->where("usersId", $usersId)->first();

            return view('applicant.educations.create', compact('levels', 'countries', 'education'));
        }

        public function update(Request $request, $id) {
            /*validate required fields*/
            $attributes = request()->validate([
                'level'         => 'required|exists:extra_levels,id',
                'country'       => 'required|exists:extra_countries,id',
                'school'        => 'required|max:255',
                'date_start'    => 'required|max:255',
                'date_year'     => 'required|max:255',
                'attainment'    => 'required|max:255',
            ]);

            DB::beginTransaction();
            try {
                $education 				= UserEducation::find($id);
                $education->levelId 	= $request->input('level');
                $education->countryId 	= $request->input('country');
                $education->name 		= $request->input('school');
                $education->dateStart 	= $request->input('date_start');
                $education->dateEnd 	= $request->input('date_year');
                $education->attainment  = $request->input('attainment');

                $education->save();
        
                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(258), '');
            return redirect('applicant/education');
        }

     
        public function destroy($id) {
        	try {
                $usersId = Auth::user()->id;
        		
                UserEducation::where('id', $id)->where("usersId", $usersId)->first()->delete();
                return response()->json(['result' => true,'message' => MaintenanceLocale::getLocale(256)]);
        	}

        	catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false,'message' => $ex->getMessage()], 500);
            }
        }
    }
?>