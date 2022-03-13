<?php

namespace App\Http\Controllers\Subscriber;

use DB;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*get users template*/
use App\SubscriberTemplates;
use App\EmployerDetail;


class SubscriberTemplate extends Controller
{
	/*list of user's template page*/
    public function index() {
        $id = Auth::user()->id;

        /*get users templates*/
        $templates = SubscriberTemplates::where("usersId", $id)->get();

        $savedStatus 		= EmployerDetail::join("maintenance_subscriptions as ms", "ms.id", "=", "employer_details.subscriptionId")
        					->where("ms.check_reserve", 1)
        					->where("employer_details.usersId", $id)->count();

        return view('subscriber.template', compact('templates', 'savedStatus'));
    }
   
   	/*create new templates into database*/
    public function store(Request $request) {
		DB::beginTransaction();
		try {
        	$id = Auth::user()->id;

        	/*create new template*/
			$template 			= new SubscriberTemplates();
			$template->usersId 	= $id;
			/*subject of the email*/
			$template->subject 	= $request->input("subject");
			/*content of the email*/
			$template->message 	= $request->input("message");

			/*save to database*/
			$template->save();

			DB::commit();

			return response()->json(['result' => true]);
		}

		catch (\Exception $ex) {
			DB::rollback();
			return response()->json(['result' => $ex->getMessage()], 500);
		}
    }

    /*update template details into database*/
    public function update(Request $request){
    	DB::beginTransaction();
		try {
        	$id 	= Auth::user()->id;
        	$tId 	= $request->input("id");

        	/*update the template*/
			$template 			= SubscriberTemplates::find($tId);
			/*subject of the email*/
			$template->subject 	= $request->input("subject");
			/*content of the email*/
			$template->message 	= $request->input("message");
			/*save to database*/
			$template->save();

			DB::commit();

			return response()->json(['result' => true]);
		}

		catch (\Exception $ex) {
			DB::rollback();
			return response()->json(['result' => $ex->getMessage()], 500);
		}
    }

    /*get template details by id*/
    public function show(Request $request) {
    	DB::beginTransaction();
		try {
        	$id 	= Auth::user()->id;
        	$tId 	= $request->input("id");

        	/*template details*/
			$template 			= SubscriberTemplates::find($tId);

			/*return the details*/
			return response()->json($template);
		}

		catch (\Exception $ex) {
			DB::rollback();
			return response()->json(['result' => $ex->getMessage()], 500);
		}
    }
}
