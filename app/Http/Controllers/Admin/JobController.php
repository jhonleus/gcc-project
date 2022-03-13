<?php

namespace App\Http\Controllers\Admin;

use File;
use DB;
use Auth;
use Crypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\EmployerJob;

class JobController extends Controller
{
    public function index() {   
        $pending        = EmployerJob::where("isValidate", 0)->get()->sortBy("created_at");
        $approves       = EmployerJob::where("isValidate", 1)->get()->sortBy("created_at");
        $rejects        = EmployerJob::where("isValidate", 2)->get()->sortBy("created_at");
        $resubmitted    = EmployerJob::where("isValidate", 3)->get()->sortBy("created_at");

        return view("admin.approval.jobs.index", compact("pending", "approves", "rejects", "resubmitted"));
    }

    public function edit($id)
    {
        $id     = Crypt::decrypt($id);
        $job    = EmployerJob::where("id", $id)->first();

        return view('admin.approval.jobs.details', compact('id', 'job'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $status             = $request->input('isValidate'); 
            $job                = EmployerJob::find($id);
            $job->isValidate    = $status;
            $job->save();
            DB::commit();

            if($status==1) {
                $msg = "APPROVED";
            }
            else {
                $msg = "DECLINED";
            }

            alert()->success('SUCCESSFULLY ' . $msg,'');
            return redirect('admin/jobs');
        }

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
