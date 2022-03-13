<?php

namespace App\Http\Controllers\Applicant;

use App\CompanyLogo;
use DB;
use Redirect;
use Auth;
use Mail;
use Crypt;
use App\User;
use App\UserDocument;
use App\EmployerDetail;
use App\UserApplication;
use App\UserLocale;
use App\MaintenanceLocale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppliedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;

        $applications = UserApplication::where('usersId',$id)->with('application')->get();
 
        return view('applicant.profile.application', compact('applications'));
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
        
        $companyId = $request->input('companyId');
        $jobId = $request->input('jobId');

        $decrypt_companyId = Crypt::decrypt($companyId);
        $decrypt_jobId = Crypt::decrypt($jobId);
        $id = Auth::user()->id;

        $employer = EmployerDetail::where('usersId',$companyId)->first();
            
        if ($request->has($request['btnProfile'])) {

            $get_resume = UserDocument::where('usersId', $id)->where('filetype', 'resume')->first();
            
            $path = $get_resume->path;
            $filename = $get_resume->filename;

            $application = new UserApplication();
            $application->usersId = $id;
            $application->jobId = $decrypt_jobId;
            $application->companyId = $decrypt_companyId;
            $application->path = $path;
            $application->filename = $filename;
            $application->status = 1;
            $application->isActive = 1;
            $application->save();

            DB::commit();

            alert()->success(MaintenanceLocale::getLocale(555), '');
            return Redirect::back();


        } else if ($request->has($request['btnUpload'])) {

            DB::beginTransaction();
            try {
                        
                if($request->hasfile('resume')) {
                        
                    $file = $request->file('resume');
                    $original = $file->getClientOriginalName();
                    $location = "documents/" . $id . '/application/';
                    
                    $application = new UserApplication();
                    $application->usersId = $id;
                    $application->jobId = $decrypt_jobId;
                    $application->companyId = $decrypt_companyId;
                    $application->path = $location;
                    $application->filename = $original;
                    $application->status = 1;
                    $application->isActive = 1;
                    $application->save();
            
                    $to_name = $employer->company; // NAME OF THE INQURIES HANDLING
            
                    $to_email = $employer->email; // EMAIL OF THE INQURIES HANDLING
            
                    $data = array('body' => 'USER APPLIED', 'phone' => '123456789'); //Message and phone number of the user
            
                    //sending function
                    Mail::send('emails.inquire', $data, function($message) use ($to_name, $to_email) {
            
                        $message->to($to_email, $to_name) //sending message to the gcc email account
            
                        ->subject("Inquiries"); //the subject will show in the gmail 
                    });
        
                    DB::commit();

                    alert()->success(MaintenanceLocale::getLocale(555), '');
                    return Redirect::back();
                }

            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
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
        UserApplication::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('applicant/jobs/applied');
    }
}
