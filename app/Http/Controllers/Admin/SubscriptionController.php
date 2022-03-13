<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscription;
use DB;
use Illuminate\Support\Facades\Validator;
use App\MaintenanceSubscriptions;
use Alert;
use App\UserLocale;
use App\Plan;
use App\MaintenanceLocale;
use Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $plan = new Plan();

        // $customer = $plan->gateway()->customer()->find(Auth::user()->id);
        
        $subscriptions = MaintenanceSubscriptions::all();

        return view('admin.maintenance.subscriptions', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $plans = Plan::all();
        return view('admin.maintenance.subscriptions_create',compact('plans'));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $subscriptions = new MaintenanceSubscriptions();
            $subscriptions->title = $request->get('title');
            $subscriptions->plan_name = $request->get('plan_name');
            $subscriptions->price = $request->get('price');
            $subscriptions->expiration = $request->get('expiration');

            $limit = '';
            if($request->has('check_limit') ){
                $limit = 999;
            } else {
                $limit = $request->get('limit');
            }

            $subscriptions->limit = $limit;

            $check_limit = '';
            if($request->has('check_limit') ){
                $check_limit = true;
            } else {
                $check_limit = false;
            }

            $check_reserve = '';
            if($request->has('check_reserve') ){
                $check_reserve = true;
            } else {
                $check_reserve = false;
            }

            $check_technical = '';
            if($request->has('check_technical') ){
                $check_technical = true;
            } else {
                $check_technical = false;
            }

            $check_email = '';
            if($request->has('check_email') ){
                $check_email = true;
            } else {
                $check_email = false;
            }

            $check_applicant = '';
            if($request->has('check_applicant') ){
                $check_applicant = true;
            } else {
                $check_applicant = false;
            }

            $check_profile = '';
            if($request->has('check_profile') ){
                $check_profile = true;
            } else {
                $check_profile = false;
            }

            $subscriptions->check_limit = $check_limit;
            $subscriptions->check_applicant = $check_applicant;
            $subscriptions->check_profile = $check_profile;
            $subscriptions->check_reserve = $check_reserve;
            $subscriptions->check_technical = $check_technical;
            $subscriptions->check_email = $check_email;

            $subscriptions->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        alert()->success(MaintenanceLocale::getLocale(257),'');
        return redirect('admin/subscriptions');
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
        $subscriptions = MaintenanceSubscriptions::where('id', $id)->first();

        return view('admin.maintenance.subscriptions_edit', compact('subscriptions'));
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
            $subscriptions = MaintenanceSubscriptions::find($id);
            $subscriptions->title = $request->get('title');
            $subscriptions->price = $request->get('price');
            $subscriptions->expiration = $request->get('expiration');

            $limit = '';
            if($request->has('check_limit') ){
                $limit = 999;
            } else {
                $limit = $request->get('limit');
            }

            $subscriptions->limit = $limit;

            $check_limit = '';
            if($request->has('check_limit') ){
                $check_limit = true;
            } else {
                $check_limit = false;
            }

            $check_reserve = '';
            if($request->has('check_reserve') ){
                $check_reserve = true;
            } else {
                $check_reserve = false;
            }

            $check_technical = '';
            if($request->has('check_technical') ){
                $check_technical = true;
            } else {
                $check_technical = false;
            }

            $check_email = '';
            if($request->has('check_email') ){
                $check_email = true;
            } else {
                $check_email = false;
            }

            $check_applicant = '';
            if($request->has('check_applicant') ){
                $check_applicant = true;
            } else {
                $check_applicant = false;
            }

            $check_profile = '';
            if($request->has('check_profile') ){
                $check_profile = true;
            } else {
                $check_profile = false;
            }

            $subscriptions->check_limit = $check_limit;
            $subscriptions->check_applicant = $check_applicant;
            $subscriptions->check_profile = $check_profile;
            $subscriptions->check_reserve = $check_reserve;
            $subscriptions->check_technical = $check_technical;
            $subscriptions->check_email = $check_email;

            $subscriptions->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        alert()->success(MaintenanceLocale::getLocale(258),'');
        return redirect('admin/subscriptions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MaintenanceSubscriptions::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('admin/subscriptions');
    }
}
