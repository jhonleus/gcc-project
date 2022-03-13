<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;
use App\UserDocument;
use App\EmployerJob;
use App\SubscriberReviews;
use App\SubscriberOtc;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //fetching all the applicant counts records to admin dashboard 
        $users1 = User::all()->where('rolesId','1');

        //fetching all the employers counts records to admin dashboard 
        $users2 = User::all()->where('rolesId','2');

        //fetching all the organization counts records to admin dashboard 
        $users3 = User::all()->where('rolesId','3');

        //fetching all the school counts records to admin dashboard 
        $users4 = User::all()->where('rolesId','4');

        $userApproval = UserDocument::with('requirements')->where('filetype', 'document3')
                        ->where(function($q) {
                            $q->whereHas('requirements', function($r) {
                                $r->where('isActive', 0); 
                            });
                        })->count();

        $jobApproval = EmployerJob::where("isValidate", 0)->get()->sortBy("created_at");
        $reviewApproval = SubscriberReviews::with("users")->where("isActive", 0)->get()->sortBy("created_at");
        $otcApproval = SubscriberOtc::where("isActive", 0)->get()->sortBy("created_at");

        return view('admin.index',compact('userApproval','jobApproval','reviewApproval','otcApproval','users1','users2','users3','users4'));

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
        //
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
        //
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
