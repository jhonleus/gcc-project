<?php

namespace App\Http\Controllers\Admin;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserLocale;
use App\SubscriberAffilation;
use App\MaintenanceLocale;
class OrganizationlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        

     $user = User::where("rolesId", 3)->get();
        return view('admin.reports.organizationlist.index', compact('user'));       


       
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
        try {
            $destroy = User::findOrFail($id);
            $destroy->delete();
            alert()->success(MaintenanceLocale::getLocale(256),'');
        }

        catch (\Exception $ex) {
            DB::rollback();
            alert()->error($ex->getMessage(),'');
        }
        return redirect('admin/reports/organizationlist');
    }
}
