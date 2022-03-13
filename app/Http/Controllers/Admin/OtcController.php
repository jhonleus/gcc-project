<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\MaintenanceLocale;
use App\SubscriberOtc;
use App\SubscriptionDetails;
use App\EmployerReason;


class OtcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending = SubscriberOtc::where("isActive", 0)->get()->sortBy("created_at");
        $approves = SubscriberOtc::where("isActive", 1)->get()->sortBy("created_at");
        $rejects = SubscriberOtc::where("isActive", 2)->get()->sortBy("created_at");
        $resubmitted = SubscriberOtc::where("isActive", 4)->get()->sortBy("created_at");
        
        return view('admin.approval.otc.index', compact('pending', 'approves', 'rejects', 'resubmitted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
            try {

                $id = $request->input('modal-id');
                $usersId = $request->input('modal-userid');
                
                $otc = SubscriberOtc::find($id);
                $otc->isActive = 2;
                $otc->save();

                $reasons = EmployerReason::firstOrNew(array('usersId' => $usersId));
                $reasons->usersId = $usersId;
                $reasons->reason = $request->input('txt_reason');
                $reasons->save();

                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(246),'');
                return redirect('admin/over-the-counter');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            try {
                
                $otc = SubscriberOtc::find($id);
                $otc->isActive = 1;
                $otc->save();

                $last = new Carbon('last day of next month');
                $last->startOfDay()->addDays(7);

                // Save Subscriber Details to database
                $subscriptiondetails                    = new SubscriptionDetails();
                $subscriptiondetails->usersId           = $otc->usersId;
                $subscriptiondetails->subscriptionId    = $otc->subscriptionId;
                $subscriptiondetails->subscription_code = $otc->subscriptionId;
                $subscriptiondetails->first_day         = now();
                $subscriptiondetails->last_day          = $last;
                $subscriptiondetails->isPaypal          = false;
                $subscriptiondetails->paymentId         = null;
                $subscriptiondetails->save();

                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(247),'');
                return redirect('admin/over-the-counter');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
