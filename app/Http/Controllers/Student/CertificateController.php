<?php

    namespace App\Http\Controllers\Student;

    use DB;
    use Auth;
    use File;

    use App\UserCertification;
    use App\Http\Controllers\Controller;
    use App\MaintenanceLocale;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class CertificateController extends Controller {

        public function index() {
            $usersId    = Auth::user()->id;
            $documents 	= UserCertification::where('usersId', $usersId)->orderBy('id', 'desc')->paginate(10);

            return view('student.certificates.index', compact('documents'));
        }

        public function download($id) {
            $usersId    = Auth::user()->id;
            $documents 	= UserDocument::where('id', $id)->where("usersId", $usersId)->first();

            $file_path 	= public_path($documents->path . '' . $documents->filename);
            $replace 	= str_replace('/', "\'", $file_path);
            $final 		= str_replace("'", "", $replace);

            return response()->download($final);
        }

        public function create() {
            return view('student.certificates.create');
        }

        public function store(Request $request)  {
            /*validate required fields*/
            $attributes = request()->validate([
                'certificate'   => 'required',
                'type'          => 'required|max:255',
                'number'        => 'required|max:255',
                'accreditor'    => 'required|max:255',
                'date_issued'   => 'required|before:'.date("Y-m-d H:i:s", time()),
            ]);

            DB::beginTransaction();
            try {

                $usersId 	= Auth::user()->id;
                $image 	    = $request->file('certificate');

                if ($request->hasFile('certificate')) {

                    $file_1         = $request->file('certificate');
                    $extension_1    = $file_1->getClientOriginalExtension();

                    $destinationPath 	= $usersId . "/documents/certification/";
                    $filename 			= time() . "_" . $request->input("type") . "." . $extension_1;
                    
                    $image->move(public_path()."/".$destinationPath, $filename);
                    $fullPath 			= $destinationPath;

                    $documents	 			= new UserCertification();
                    $documents->usersId 	= $usersId;
                    $documents->filename 	= $filename;
                    $documents->path        = $fullPath;
                    $documents->type 	    = $request->input("type");
                    $documents->number      = $request->input("number");
                    $documents->accreditor  = $request->input("accreditor");
                    $documents->date_issued = $request->input("date_issued");

                    $documents->save();
                    DB::commit();

                    alert()->success(MaintenanceLocale::getLocale(257), '');
                    return redirect('applicant/certificate');
                }

            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }

        public function destroy($id) {
            try {
                $usersId = Auth::user()->id;
            	UserDocument::where("id", $id)->where("usersId", $usersId)->first()->delete();
                return response()->json(['result' => true, 'message' => MaintenanceLocale::getLocale(256)]);
            }

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()], 500);
            }
        }
    }
?>