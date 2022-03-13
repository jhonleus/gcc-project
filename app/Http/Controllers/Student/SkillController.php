<?php

    namespace App\Http\Controllers\Student;

    use DB;
    use Auth;

    use App\MaintenanceLocale;
    use App\User;
    use App\UserSkill;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class SkillController extends Controller
    {
        public function index() {   
            $usersId = Auth::user()->id;
            $user 	 = User::where('id', $usersId)->with('skills')->first();

            return view('student.skills.index', compact('user'));
        }

        public function create() {
           $usersId = Auth::user()->id;
           $skills 	= UserSkill::where('usersId', $usersId)->first();

           return view('student.skills.create', compact('skills'));
        }
      
        public function store(Request $request) {
            /*validate required fields*/
            $attributes = request()->validate([
                'strong'    => 'required',
                'weak'      => 'required',
            ]);

            DB::beginTransaction();
            try {

               	$usersId = Auth::user()->id;

                $parameters             = array('usersId' => $usersId);

                $skill 	                = UserSkill::firstOrNew($parameters);
                $skill->strongPoints 	= $request->input('strong');
                $skill->weakPoints 		= $request->input('weak');
                $skill->save();
        
                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(257), '');
            return redirect('applicant/skills');
        }

        public function edit() {
            $usersId 	= Auth::user()->id;
            $skills     = UserSkill::where('usersId', $usersId)->first();

            return view('student.skills.create', compact('skills'));
        }

        public function update(Request $request, $id) {
            /*validate required fields*/
            $attributes = request()->validate([
                'strong'    => 'required',
                'weak'      => 'required',
            ]);

            DB::beginTransaction();
            try {
                $usersId = Auth::user()->id;

                $parameters             = array('usersId' => $usersId);
                
                $skill                  = UserSkill::firstOrNew($parameters);
                $skill->strongPoints 	= $request->input('strong');
                $skill->weakPoints 		= $request->input('weak');
                $skill->save();
        
                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(258), '');
            return redirect('applicant/skills');
        }
    }
