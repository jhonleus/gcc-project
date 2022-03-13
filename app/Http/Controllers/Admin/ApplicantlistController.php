<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\UserDetail;
use DB;
use File;
use App\UserCertification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use Auth;
use App\UserDocument;
use App\UserLocale;
use App\MaintenanceLocale;

class ApplicantlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
		$users = User::where("rolesId", 1)->get();
        $id        = Auth::user()->id;
        $documents  = UserCertification::where('usersId', $id)->orderBy('id', 'desc')->get();

        
        return view('admin.reports.applicantlist.index', compact('users','documents')); 
    }

    
      public function download($id) {
        $documents  = UserDocument::where('id', $id)->first();

        $file_path  = public_path($documents->path . '' . $documents->filename);
        $replace    = str_replace('/', "\'", $file_path);
        $final      = str_replace("'", "", $replace);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
  

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
        //deleting all applicant data
        DB::table('users')->where('id',$id)->delete();

        //after the delete function run alert will popup 
        alert()->success('Success','Deleted successfully!');
        
        //and redirect to the applicantlist table page
        return redirect('admin/reports/applicantlist');
    }
}