<?php
	namespace App\Http\Controllers\School;

	use DB;
	use Auth;

	use App\User;
	use App\SubscriberPartner;
	use App\EmployerDetail;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;

	class PartnerController extends Controller {
		
    	public function index() {
			$usersId = Auth::user()->id;
			$partners = SubscriberPartner::orWhere("usersId", $usersId)->orWhere("companyId", $usersId)->paginate(10);

			return view('school.partners.index', compact('partners'));	
    	}

	    public function create() {
	        $usersId  = Auth::user()->id;
	        $rolesId 	= Auth::user()->rolesId;

	        $users = User::where("id", "!=", $usersId)->where("rolesId", $rolesId)->whereNotIn('id',function($query) {
					$usersId = Auth::user()->id;
					$query->select('companyId')->from('subscriber_partners')->orWhere("usersId", $usersId)->orWhere("companyId", $usersId);
				})->whereNotIn('id',function($query) {
					$usersId = Auth::user()->id;
					$query->select('usersId')->from('subscriber_partners')
					->orWhere("usersId", $usersId)->orWhere("companyId", $usersId);
				})->get();

			return view('school.partners.create', compact('users'));
	    }

	    public function store(Request $request) {
	        $attributes = request()->validate([
	            'partners'  => 'required|exists:users,id'
	        ]);

	       	DB::beginTransaction();
	       	try {
	            $usersId 	= Auth::user()->id;
	       	    $partners 	= $request->input('partners');

	            foreach ($partners as $partner) {
	                $part = new SubscriberPartner();
	                $part->usersId  = $usersId;
	                $part->companyId= $partner;
	                $part->save();
	            }

	       	    DB::commit();

	            alert()->success("SUCCESSFULLY ADDED",'');
	            return redirect('school/partners');
	       	} 

	       	catch (\Exception $ex) {
	       	    DB::rollback();
	       	    return response()->json(['error' => $ex->getMessage()], 500);
	       	}
	    }

	    public function verify(Request $request) {
	        DB::beginTransaction();
	        try {
	            $validator = Validator::make($request->all(), [
	                'id'  => 'required|exists:subscriber_partners,id'
	            ]);

	            if ($validator->fails()) {
	                return response()->json(array(
	                    'result'    => false,
	                    'message'   => $validator->getMessageBag()->toArray()
	                    ));
	                }
	            else {
					$usersId                 = $request->input('id');
					$partner            = SubscriberPartner::find($usersId);
					$partner->isActive  = 1;
					$partner->save();

					DB::commit();
					return response()->json(['result' => true, 'message' => "SUCCESSFULLY VERIFIED"]);
	            }
	        } 

	        catch (\Exception $ex) {
	            DB::rollback();
	            return response()->json(['result' => false, 'message' => $ex->getMessage()]);
	        }
	    }
	}
?>