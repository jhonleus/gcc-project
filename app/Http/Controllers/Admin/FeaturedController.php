<?php

    namespace App\Http\Controllers\Admin;

    use DB;
    use Auth;

    use App\User;
    use App\MaintenanceLocale;
    use App\FeaturedSubscriber;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class FeaturedController extends Controller {

        /*list of featured*/
        public function index() {
            /*user's id*/
          	$usersId = Auth::user()->id;
            
            /*get all user's featured*/
            $subscribers = FeaturedSubscriber::all();

            $users = User::whereNotIn('id',function($query) {
                        $query->select('usersId')->from('featured_subscriber');
                    })->get();

            return view('admin.featured.index', compact('subscribers', 'users'));
        }

        /*insert featured to database*/
        public function store(Request $request) {

            /*validate required fields*/
            $attributes = request()->validate([
                'subscribers' => 'required|array|exists:users,id'
            ]);

           	DB::beginTransaction();
           	try {
                /*user's details*/
                $usersId    = Auth::user()->id;
           	    $featured   = $request->input('subscribers');

                /*insert all elements of the array to database*/
                foreach ($featured as $subscribers) {

                    $subscriber             = new FeaturedSubscriber();
                    $subscriber->usersId    = $subscribers;
                    $subscriber->save();

                }

           	    DB::commit();

                alert()->success(MaintenanceLocale::getLocale(257),'');
                return redirect('admin/featured');
           	} 

           	catch (\Exception $ex) {
           	    DB::rollback();
           	    return response()->json(['error' => $ex->getMessage()], 500);
           	}
        }

        public function destroy($id) {
            FeaturedSubscriber::findOrFail($id)->delete();
            alert()->success("SUCCESSFULLY DELETED");
            return redirect('admin/featured');
        }
    }
?>