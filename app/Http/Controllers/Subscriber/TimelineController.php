<?php
namespace App\Http\Controllers\Subscriber;

use DB;
use Auth;
use Alert;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimelineController extends Controller
{
	/*create news & events page*/
    public function index() {
		$id = Auth::user()->id;

		/*get list of news & events*/
		$users = User::where('id',$id)->orderBy('created_at', 'desc')->get();

		return view('subscriber.timeline', compact('users'));
    }

    public function store(Request $request) {

    }

    public function destroy($id){
		DB::table('news_and_events')->where('id',$id)->delete();

		alert()->success('Success','Deleted successfully!');
		return redirect('timeline');
    }
}
