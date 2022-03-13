<?php

namespace App\Http\Controllers\Admin;

use File;
use DB;
use Auth;
use Crypt;
use Carbon\Carbon;
use App\UserToken;
use App\User;
use App\UserDocument;
use App\EmployerReason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserLocale;
use App\MaintenanceSubscriptions;
use App\MaintenanceLocale;
use App\SubscriptionDetails;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $dpendings = UserDocument::with('requirements')->where(function($q) {
                            $q->where('filetype', "document3");
                        })
                        ->where(function($q) {
                            $q->whereHas('requirements', function($r) {
                                $r->where('isActive', 0); 
                            });
                        })->get();

        $dapproves = UserDocument::with('requirements')->where(function($q) {
                            $q->where('filetype', "document3");
                        })
                        ->where(function($q) {
                            $q->whereHas('requirements', function($r) {
                                $r->where('isActive', 1); 
                            });
                        })->get();

        $drejects = UserDocument::with('requirements')->where(function($q) {
                            $q->where('filetype', "document3");
                        })
                        ->where(function($q) {
                            $q->whereHas('requirements', function($r) {
                                $r->where('isActive', 2); 
                            });
                        })->get();

        $dresubmits = UserDocument::with('requirements')->where(function($q) {
                            $q->where('filetype', "document3");
                        })
                        ->where(function($q) {
                            $q->whereHas('requirements', function($r) {
                                $r->where('isActive', 3); 
                            });
                        })->get();

        $pending    = $dpendings->count();
        $approved   = $dapproves->count();
        $rejected   = $drejects->count();
        $resubmitted= $dresubmits->count();
        

        return view('admin.approval.index', compact('pending', 'approved', 'rejected', 'resubmitted', 'dpendings', 'dapproves', 'drejects', 'dresubmits'));
    }

    public function download($id) {
        $documents = UserDocument::where('id', $id)->first();

        $file_path = url($documents->path.''.$documents->filename);
        $replace = str_replace('/', "\'", $file_path);
        $final = str_replace("'", "", $replace);
        
        return response()->download($final);
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($decrypt)
    {
        $id = Crypt::decrypt($decrypt);
        $document1 = UserDocument::where('usersId', $id)->where('filetype', 'document1')->first();
        $document2 = UserDocument::where('usersId', $id)->where('filetype', 'document2')->first();
        $document3 = UserDocument::where('usersId', $id)->where('filetype', 'document3')->first();

        return view('admin.approval.show', compact('id', 'document1', 'document2', 'document3'));
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
        
        if ($request->has($request['btnApprove'])) {
            DB::beginTransaction();
            try {
                
                $free = MaintenanceSubscriptions::where('price', '<', 1)->first();

                $users = User::find($id);
                $users->isActive = 1;
                $users->save();

                // Save Subscriber Details to database
                $subscriptiondetails                    = new SubscriptionDetails();
                $subscriptiondetails->usersId           = $id;
                $subscriptiondetails->subscriptionId    = $free->id;
                $subscriptiondetails->subscription_code = $free->id;
                $subscriptiondetails->first_day         = now();
                $subscriptiondetails->last_day          = null;
                $subscriptiondetails->save();

                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(247),'');
                return redirect('admin/approval');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

          

        } else if ($request->has($request['btnReject'])) {
            DB::beginTransaction();
            try {
                
                $users = User::find($id);
                $users->isActive = 2;
                $users->save();

                $reasons = EmployerReason::firstOrNew(array('usersId' => $id));
                $reasons->usersId = $id;
                $reasons->reason = $request->input('txt_reason');
                $reasons->save();

                $delete_document = UserDocument::where('usersId', $id)->where('filetype', 'document1')->where('filetype', 'document2')->where('filetype', 'document3');
                $delete_document->delete();

                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(246),'');
                return redirect('admin/approval');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

     
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
