<?php

    namespace App\Http\Controllers\Organization;

    use DB;
    use Auth;

    use App\User;
    use App\MaintenanceLocale;
    use App\SubscriberAffilation;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AffilationController extends Controller {

        /*list of affilations*/
        public function index() {
            /*user's id*/
          	$usersId          = Auth::user()->id;
            
            /*get all user's affilations*/
            $affilations  = SubscriberAffilation::orWhere("usersId", $usersId)->orWhere("companyId", $usersId)->paginate(10);

            return view('organization.affilations.index', compact('affilations'));
        }
        
        /*create new affilations*/
        public function create() {
            /*user's id*/
            $usersId = Auth::user()->id;
            /*user's roles id*/
            $rolesId = Auth::user()->rolesId;

            /*get user's details*/
            $users = User::where("id", "!=", $usersId)->whereNotIn('id',function($query) {
                        $usersId = Auth::user()->id;
                        $query->select('companyId')->from('subscriber_affilations')->orWhere("usersId", $usersId)->orWhere("companyId", $usersId);
                    })->whereNotIn('id',function($query) {
                        $usersId = Auth::user()->id;
                        $query->select('usersId')->from('subscriber_affilations')->orWhere("usersId", $usersId)->orWhere("companyId", $usersId);
                    })->get();

    		return view('organization.affilations.create', compact('users'));
        }

        /*insert affilations to database*/
        public function store(Request $request) {
            /*validate required fields*/
            $attributes = request()->validate([
                'affilations' => 'required|array|exists:users,id'
            ]);

           	DB::beginTransaction();
           	try {
                /*user's details*/
                $usersId = Auth::user()->id;
           	    $affilations = $request->input('affilations');

                /*insert all elements of the array to database*/
                foreach ($affilations as $affilation) {
                    $affilate             = new SubscriberAffilation();
                    /*id of the user who created/added the affilations*/
                    $affilate->usersId    = $usersId;
                    /*id of the added affilations*/
                    $affilate->companyId  = $affilation;
                    /*save to database*/
                    $affilate->save();
                }

           	    DB::commit();

                /*return to affilation page*/
                alert()->success(MaintenanceLocale::getLocale(257),'');
                return redirect('organization/affilations');
           	} 

           	catch (\Exception $ex) {
           	    DB::rollback();
           	    return response()->json(['error' => $ex->getMessage()], 500);
           	}
        }

        /*verify those affilation who added them as affilations*/
        public function verify(Request $request) {
            DB::beginTransaction();
            try {
                /*validate required fields*/
                $validator = Validator::make($request->all(), [
                    'id'  => 'required|exists:subscriber_affilations,id'
                ]);

                /*if validation fails*/
                if ($validator->fails()) {
                    return response()->json(array(
                        'result'    => false,
                        'message'   => $validator->getMessageBag()->toArray()
                    ));
                }
                /*if meets all the validation*/
                else {
                    /*get affilation id*/
                    $affilationId   = $request->input('id');
                    /*get user's id*/
                    $usersId = Auth::user()->id;

                    /*update the record to database*/
                    $affilation     = SubscriberAffilation::where('companyId', $usersId)->where('id', $affilationId)->first();
                    /*1 means verified*/
                    $affilation->isActive = 1;
                    /*save to database*/
                    $affilation->save();

                    DB::commit();
                    return response()->json(['result' => true, 'message' => MaintenanceLocale::getLocale(354)]);
                }
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['result' => false, 'message' => $ex->getMessage()]);
            }
        }
    }
?>