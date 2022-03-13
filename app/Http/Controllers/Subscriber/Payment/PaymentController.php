<?php

namespace App\Http\Controllers\Subscriber\Payment;

use DB;
use Auth;
use Carbon\Carbon;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/** Paypal Details classes **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use App\MaintenanceSubscriptions;
use App\SubscriptionDetails;
use App\PaymentDetails;

class PaymentController extends Controller
{
    private $api_context;

    public function __construct()
    {
        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret'))
        );

        $this->api_context->setConfig(config('paypal.settings'));
    }

    public function createPayment(Request $request) {

        $attributes = request()->validate([
            'subscriptionId' => 'required|exists:maintenance_subscriptions,id'
        ]);

        $subscription   = MaintenanceSubscriptions::find($request->subscriptionId);
        $pay_amount     = $subscription->price;

        $payment                    = new PaymentDetails();
        $payment->id                = time();
        $payment->usersId           = Auth::user()->id;
        $payment->subscriptionId    = $subscription->id;
        $payment->isPaymentSuccess  = false;
        $payment->save();

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Subscription for '.$subscription->plan_name)->setCurrency('USD')->setQuantity(1)->setPrice($pay_amount)->setSku($request->subscriptionId);

        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $amount = new Amount();
        $amount->setCurrency('USD')->setTotal($pay_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Payment for GCC Subscription')->setInvoiceNumber($payment->id);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('confirm-payment'))->setCancelUrl(url()->current());

        $payment = new Payment();
        $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

        try {
            $payment->create($this->api_context);
        } 

        catch (PayPalConnectionException $ex){
            alert()->error('There is something wrong with the request!', '');
            return redirect('pricing');
        } 

        catch (Exception $ex) {
            alert()->error('There is something wrong with the request!', '');
            return redirect('pricing');
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if(isset($redirect_url)) {
            return redirect($redirect_url);
        }

        alert()->error('Unknown error occurred!', '');
        return redirect('pricing');
    }

    public function confirmPayment(Request $request) {

        try {

            if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))) {
                alert()->error('Payment was not successful!', '');
                return redirect('pricing');
            }
            
            $payment = Payment::get($request->query('paymentId'), $this->api_context);

            $execution = new PaymentExecution();
            $execution->setPayerId($request->query('PayerID'));

            $result = $payment->execute($execution, $this->api_context);

            if ($result->getState() != 'approved') {

                alert()->error('Payment was not successful!', '');
                return redirect('pricing');

            }

            else {

                DB::beginTransaction();
                $paypalResponse  = json_decode($result, true);

                $referenceId     = $paypalResponse['transactions'][0]['invoice_number'];
                $totalAmount     = $paypalResponse['transactions'][0]['amount']['total'];
                $payerId         = $paypalResponse['payer']['payer_info']['payer_id'];
                $paymentId       = $paypalResponse['id'];
                $paypalResponse  = $paypalResponse['transactions'][0]['related_resources'][0]['sale']['state'];

                $data = [];

                $payment = PaymentDetails::find($referenceId);

                if(!$payment->isPaymentSuccess) {

                    $payment->payerId          = $payerId;
                    $payment->paymentId        = $paymentId;
                    $payment->amount           = $totalAmount;
                    $payment->isPaymentSuccess = true;
                    $payment->paypalResponse   = $paypalResponse;
                    $payment->save();

                    $last = new Carbon('last day of next month');
                    $last->startOfDay()->addDays(7);

                    $subs                   = new SubscriptionDetails();
                    $subs->usersId          = Auth::user()->id;
                    $subs->subscriptionId   = $payment->subscriptionId;
                    $subs->first_day        = now();
                    $subs->last_day         = $last;
                    $subs->isPaypal         = true;
                    $subs->paymentId        = $payment->id;
                    $subs->save();

                    $data['payment_details']        = PaymentDetails::find($referenceId);
                    $data['subscription_details']   = SubscriptionDetails::find($subs->id);

                    DB::commit();

                }

                alert()->success('Payment made successfully!','');
                return redirect('pricing');

            }

        } 

        catch (PayPalConnectionException $ex){

            dd($ex);
            die();
            alert()->error('There is something wrong with the request!', '');
            return redirect('pricing');
        } 

        catch (Exception $ex) {

            dd($ex);
            alert()->error('There is something wrong with the request!', '');
            return redirect('pricing');
        }

    }

    public function confirmSubscription(Request $request) {

        DB::beginTransaction();

        try {

            $entityBody     = file_get_contents('php://input');
            $paypalResponse  = json_decode($entityBody, true);
            
            $referenceId     = $paypalResponse['resource']['invoice_number'];
            $totalAmount     = $paypalResponse['resource']['amount']['total'];
            $payerId         = $paypalResponse['resource']['id'];
            $paymentId       = $paypalResponse['resource']['parent_payment'];
            $paypalResponse  = $paypalResponse['resource']['state'];

            $data = [];

            $payment = PaymentDetails::find($referenceId);

            if(!$payment->isPaymentSuccess) {

                $payment->payerId          = $payerId;
                $payment->paymentId        = $paymentId;
                $payment->amount           = $totalAmount;
                $payment->isPaymentSuccess = true;
                $payment->paypalResponse   = $paypalResponse;
                $payment->save();

                $last = new Carbon('last day of next month');
                $last->startOfDay()->addDays(7);

                $subs                   = new SubscriptionDetails();
                $subs->usersId          = $payment->userId;
                $subs->subscriptionId   = $payment->subscriptionId;
                $subs->first_day        = now();
                $subs->last_day         = $last;
                $subs->isPaypal         = true;
                $subs->paymentId        = $paymentId;
                $subs->save();

                $data['payment_details']        = PaymentDetails::find($referenceId);
                $data['subscription_details']   = SubscriptionDetails::find($subs->id);

                DB::commit();

            }   

            

            echo json_encode($data);

        } 

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }
}