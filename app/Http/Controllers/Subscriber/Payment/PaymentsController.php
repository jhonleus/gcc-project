<?php

namespace App\Http\Controllers\Subscriber\Payment;

use DB;
use Auth;
use Crypt;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*list of subscribers payment*/
use App\PaymentDetails;

/*employer details*/
use App\EmployerDetail;
/*school details*/
use App\SchoolDetail;

/*list of subscriber's details*/
use App\SubscriptionDetails;
/*list of subscription*/
use App\MaintenanceSubscriptions;
use App\Plan;

use App\ExtraBank;
use App\SubscriberOtc;

class PaymentsController extends Controller
{

  /*create payment / store to database*/
  public function store(Request $request)
  {
    DB::beginTransaction();
    try {

      $id                 = Auth::user()->id;
      $subscriptionId     = $request->input('subscriptionId');

      if($subscriptionId==1) {
        $subscriptionStatus = false;

        /*check if user already purchased a free*/
        $checkPurchased = SubscriptionDetails::where("usersId", $id)->where("subscriptionId", $subscriptionId)->count();

        if($checkPurchased==0) {
          $subscriptionStatus = true;
        }
        else {
          $subscriptionStatus = false;
        }
      }
      else {
        $subscriptionStatus = true;
      }


      if($subscriptionStatus) {
        /*days of subscription*/
        $subscriptionLimit  = $request->input('subscriptionLimit');

        /*first day of the subscription*/
        $first_day          = Carbon::now()->toDateTimeString();

        /*last day of the subscription*/
        $last_day           = Carbon::parse($first_day)->addDays($subscriptionLimit);

        /*create payment details*/
        $payment                    = new PaymentDetails();
        $payment->usersId           = $id;
        $payment->subscriptionId    = $subscriptionId;
        $payment->isPaymentSuccess  = false;
        /*save payment*/
        $payment->save();
        /*get last inserted payment*/
        $lastInsertedID = $payment->id;

        /*if payment successfully stored*/
        if($payment->save()) {

          /*create subscription details*/
          $subs                   = new SubscriptionDetails();
          $subs->usersId          = $id;
          $subs->subscriptionId   = $request->input('subscriptionId');
          $subs->first_day        = $first_day;
          $subs->last_day         = $last_day;
          /*save subscription details*/
          $subs->save();
          /*get last inserted subscription details*/
          $lastInsertedID2        = $subs->id;

          /*if user is school*/
          if(Auth::user()->roles->id == 4) {
            /*create if not yet on the database or update if exist (this is for the reference of the subscription)*/
            $school = SchoolDetail::firstOrNew(array('usersId' => $id));
            $school->paymentId              = $lastInsertedID;
            $school->subscriptionDetailsId  = $lastInsertedID2;
            $school->subscriptionId         = $request->input('subscriptionId');
            $school->save();
          }
          /*if user is employer or organization*/
          else {
            /*create if not yet on the database or update if exist (this is for the reference of the subscription)*/
            $details = EmployerDetail::firstOrNew(array('usersId' => $id));
            $details->paymentId             = $lastInsertedID;
            $details->subscriptionDetailsId     = $lastInsertedID2;
            $details->subscriptionId        = $request->input('subscriptionId');
            $details->save();
          }
        }
        DB::commit();
        alert()->success('SUCCESSFULLY SUBSCRIBED','');
      }
      else {
        alert()->error('YOU ALREADY AVAILED THE FREE SUBSCRIPTION', '');
      }
      
    } 

    catch (\Exception $ex) {
      DB::rollback();
      return response()->json(['error' => $ex->getMessage()], 500);
    }

    return redirect('pricing');
  }

  /*payment page*/
  public function show($id) {

      $decrypt        = Crypt::decrypt($id);
      $subscription   = MaintenanceSubscriptions::find($decrypt);
      $banks          = ExtraBank::all();
 
      return view('subscriber.payment.subscription', compact('decrypt', 'subscription', 'banks'));


  }

  public function otc($id) {

    $decrypt        = Crypt::decrypt($id);
    $subscription   = MaintenanceSubscriptions::find($decrypt);
    $banks  = ExtraBank::all();

    return view('subscriber.payment.otc', compact('banks', 'decrypt', 'subscription'));
  }

  public function otcpayment(Request $request) {

        $files = $request->file('photo_name');
        $destinationPath = public_path('/receipt/');    
        $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
        $files->move(public_path()."/".$destinationPath, $profileImage);

        $otc = new SubscriberOtc();
        $otc->usersId =  Auth::user()->id;
        $otc->subscriptionId = $request->input('subscription_id');
        $otc->bankId = $request->input('banks');
        $otc->transaction = $request->input('transaction');
        $otc->name = $request->input('name');
        $otc->date = $request->input('date');;
        $otc->amount = $request->input('amount');
        $otc->receipt = $profileImage;
        $otc->save();

        alert()->success('SUCCESSFULLY SUBMITTED', 'PLEASE WAIT FOR THE APPROVAL OF THE ADMIN WITHIN 24-HOURS');
        return redirect('pricing');
  }

  public function createtoken(Request $request){
    $gateway = new Braintree\Gateway([
      'environment' => env('BRAINTREE_ENV'),
      'merchantId' => env('BRAINTREE_MERCHANT_ID'),
      'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
      'privateKey' => env('BRAINTREE_PRIVATE_KEY')
      ]);

        // Create payment token and save it to braintree and database.

    $result = $gateway->paymentMethod()->create([
      'customerId' => Auth::user()->id,
      'paymentMethodNonce' => request()->payment_method_nonce
      ]);

    $exp_month = $result->paymentMethod->expirationMonth;
    $exp_year = $result->paymentMethod->expirationYear;
    $exp_date = $exp_month . '/' . $exp_year;

    $usertoken = new UserToken();
    $usertoken->user_id = $result->paymentMethod->customerId;
    $usertoken->token = $result->paymentMethod->token;
    $usertoken->last_four = $result->paymentMethod->last4;
    $usertoken->exp_date = $exp_date;
    $usertoken->brand = $result->paymentMethod->cardType;
    $usertoken->save();

    alert()->success('Payment Method Successfully added!');
    return back();
  }

  public function deletetoken(Request $request){
    $gateway = new Braintree\Gateway([
      'environment' => env('BRAINTREE_ENV'),
      'merchantId' => env('BRAINTREE_MERCHANT_ID'),
      'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
      'privateKey' => env('BRAINTREE_PRIVATE_KEY')
      ]);

        // Check token if existing then delete
    $token_id = request()->token_id;
    $token_code = request()->token_code;
    $result = $gateway->paymentMethod()->delete($token_code);

    if ($result->success) {
            // $usertoken = new UserToken();
      $usertoken = UserToken::findOrFail($token_id);
      $usertoken->delete();
      alert()->success('Success','Payment successfully deleted!');
      return back();
    }

  }

  public function subscribe(Request $request){
    $gateway = new Braintree\Gateway([
      'environment' => env('BRAINTREE_ENV'),
      'merchantId' => env('BRAINTREE_MERCHANT_ID'),
      'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
      'privateKey' => env('BRAINTREE_PRIVATE_KEY')
      ]);


    $usertoke = request()->token_id;
    $braintree_plan = request()->braintree_plan;

    // Create subscription on braintree

    $result = $gateway->subscription()->create([
      'paymentMethodToken' => $usertoke,
      'planId' => $braintree_plan
      ]);


    $last = new Carbon('last day of next month');
    $last->startOfDay()->addDays(7);

    // Save Subscriber Details to database
    $subscriptiondetails = new SubscriptionDetails();
    $subscriptiondetails->usersId = Auth::user()->id;
    $subscriptiondetails->subscriptionId = request()->subscription_id;
    $subscriptiondetails->subscription_code = $result->subscription->id;
    //$subscriptiondetails->first_day = $result->subscription->createdAt;
    //$subscriptiondetails->last_day = $result->subscription->billingPeriodEndDate;
    $subscriptiondetails->first_day = now();
    $subscriptiondetails->last_day = $last;
    $subscriptiondetails->save();

    alert()->success('Subscribed!');
    
    $result->success;
    
    return redirect('employer/jobs');
  }

  public function cancelsubscription(Request $request){

    $gateway = new Braintree\Gateway([
      'environment' => env('BRAINTREE_ENV'),
      'merchantId' => env('BRAINTREE_MERCHANT_ID'),
      'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
      'privateKey' => env('BRAINTREE_PRIVATE_KEY')
      ]);

        // Get Subscription ID from form
    $subscription_id = request()->subscription_id;

    $result = $gateway->subscription()->cancel($subscription_id);


        // Check if Cancellation is success
    if ($result->success) {
      $subs_id = SubscriptionDetails::findOrFail($subscription_id);

      dd($subs_id);
      $subs_id->delete();
      alert()->success('successfully cancelled subscription');

    }
    return redirect('employer/payment');
  }
}
