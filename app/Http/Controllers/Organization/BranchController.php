<?php

    namespace App\Http\Controllers\Organization;

    use DB;
    use Auth;

    use App\User;
    use App\ExtraCountry;
    use App\SubscriberBranch;
    use App\MaintenanceLocale;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class BranchController extends Controller {

        /*list of branches*/
        public function index() {
            /*user's id*/
          	$usersId = Auth::user()->id;
            /*get all branches*/
            $branches = SubscriberBranch::where("usersId", $usersId)->paginate(10);
            
            return view('organization.branches.index', compact('branches'));
        }
        
        /*create new branch*/
        public function create() {
            /*list of countries*/
            $countries = ExtraCountry::orderBy('nicename')->get();
            
            return view('organization.branches.create', compact('countries'));
        }

        /*edit branch details*/
        public function edit($id) {
            /*user's id*/
            $usersId    = Auth::user()->id;
            /*list of countries*/
            $countries  = ExtraCountry::orderBy('nicename')->get();

            /*branch details*/
            $branch = SubscriberBranch::where("id", $id)->where("usersId", $usersId)->first();

            return view('organization.branches.create', compact('countries', 'branch'));
        }

        /*insert to database*/
        public function store(Request $request) {
            $attributes = request()->validate([
                'branch_name'       => 'required|max:255',
                'contact_number'    => 'required|max:255',
                'country'           => 'required|exists:extra_countries,id',
                'city'              => 'required|max:255',
                'street'            => 'required|max:255',
                'code'              => 'required|max:255',
            ]);

           	DB::beginTransaction();
           	try {
                /*user's id*/
                $usersId = Auth::user()->id;

                $branches               = new SubscriberBranch();
                $branches->usersId      = $usersId;
                $branches->branch_name  = $request->input('branch_name');
                $branches->number       = $request->input('contact_number');
                $branches->countryId    = $request->input('country');
                $branches->city         = $request->input('city');
                $branches->street       = $request->input('street');
                $branches->zipcode      = $request->input('code');
                $branches->save();

           	    DB::commit();
                
                alert()->success(MaintenanceLocale::getLocale(257),'');
                return redirect('organization/branches');
           	} 

           	catch (\Exception $ex) {
           	    DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()]);
           	}
        }

        /*update to databse*/
        public function update(Request $request, $id) {
            $attributes = request()->validate([
                'branch_name'       => 'required|max:255',
                'contact_number'    => 'required|max:255',
                'country'           => 'required|exists:extra_countries,id',
                'city'              => 'required|max:255',
                'street'            => 'required|max:255',
                'code'              => 'required|max:255',
            ]);

            DB::beginTransaction();
            try {
                /*user's id*/
                $usersId  = Auth::user()->id;

                $branches               = SubscriberBranch::where("id", $id)->where("usersId", $usersId)->first();
                $branches->branch_name  = $request->input('branch_name');
                $branches->number       = $request->input('contact_number');
                $branches->countryId    = $request->input('country');
                $branches->city         = $request->input('city');
                $branches->street       = $request->input('street');
                $branches->zipcode      = $request->input('code');
                $branches->save();

                DB::commit();
                
                alert()->success("SUCCESSFULLY UPDATED",'');
                return redirect('organization/branches');
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()]);
            }
        }

        /*delete to database*/
        public function verify(Request $request) {
            try {
                $validator = Validator::make($request->all(), [
                    'id'  => 'required|exists:subscriber_branch,id'
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'result'    => false,
                        'message'   => $validator->getMessageBag()->toArray()
                        ));
                    }
                else {
                    $id       = $request->input('id');
                    $usersId  = Auth::user()->id;

                    SubscriberBranch::where("id", $id)->where("usersId", $usersId)->delete();

                    return response()->json(['result' => true, 'message' => "SUCCESSFULLY DELETED"]);
                }
            }

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()]);
            }
        }
    }
?>