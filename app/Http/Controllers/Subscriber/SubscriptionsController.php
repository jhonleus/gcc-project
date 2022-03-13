<?php

namespace App\Http\Controllers\Subscriber;

use View;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MaintenanceSubscriptions;
use App\User;
use App\SchoolDetail;
use App\EmployerDetail;
use App\MaintenanceLocale;
use App\Plan;

class SubscriptionsController extends Controller
{
    /*list of subscriptions package*/
    public function index() {
    
    	/*get all subscriptions*/
    	$subscriptions = MaintenanceSubscriptions::all();
    	
	    $id = Auth::user()->id;

	    /*if school get school details*/
	    if(Auth::user()->rolesId == 4) {
	    	$users = SchoolDetail::where('usersId', $id)->first();
	    }
	    /*if organization or employer get employer details*/
	    else {
	   	 	$users = EmployerDetail::where('usersId', $id)->first();
	    }

	    /*if user's details is complete*/
	    if(!empty($users)) {
	   	 	$subsId = $users->subscriptionId;
	   	 	$profilestatus = true;
	    }
	    /*if user's details is incomplete*/
	    else {
	   	 	$subsId = false;
	   	 	$profilestatus = false;
        }
        
        $plans = Plan::all();
        // $customer = Plan::gateway()->customer()->find( Auth::user()->id );

        // $test = ($customer->creditCards[0]->subscriptions);

	    return view('subscriber/pricing', compact('subsId', 'plans', 'profilestatus', 'subscriptions'));
    }
}
