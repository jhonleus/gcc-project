<?php

namespace App;

use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    protected $table   = 'payment_details';
    protected $fillable = [
        'usersId', 'subscriptionId', 'isPaymentSuccess'
    ];

    public static function checkEmailStatus() {
    	$id 	= Auth::user()->id;
    	$now 	= Carbon::now()->format('Y-m-d');

		/*check if user subscribe*/
		$subscriptionCheck 	= SubscriptionDetails::where('usersId', $id)->count();
		/*if subscribe*/
		if($subscriptionCheck > 0) {
			/*check if current subscription is ended*/
	        $subscriptionEndedArray = SubscriptionDetails::where('usersId', $id)->orderBy('id', 'DESC')->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->first();

			/*if ended*/
			if(!$subscriptionEndedArray) {
				$checkEmailStatus = false;
			}
			/*if not ended*/
			else {
				/*get subscriptions details*/
				$details 	= MaintenanceSubscriptions::where('id', $subscriptionEndedArray->subscriptionId)->first();

				if($details->check_email==1) {
					$checkEmailStatus = true;
				}
				else {
					$checkEmailStatus = false;
				}
			}
			
		}
		/*if no subscription*/
		else {
			$checkEmailStatus 	= false;
		}
    	

    	return $checkEmailStatus;
    }	
}
