<?php

namespace App\Http\Controllers\Admin;

use File;
use DB;
use Auth;
use Crypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\SubscriberReviews;

class ReviewController extends Controller
{
    public function index() {   
        $pending = SubscriberReviews::with("users")->where("isActive", 0)->get()->sortBy("created_at");
        $approved = SubscriberReviews::with("users")->where("isActive", 1)->get()->sortBy("created_at");
        $rejected = SubscriberReviews::with("users")->where("isActive", 2)->get()->sortBy("created_at");
        $resubmitted = SubscriberReviews::with("users")->where("isActive", 3)->get()->sortBy("created_at");

        return view("admin.approval.reviews.index", compact('pending', 'approved', 'rejected', 'resubmitted'));
    }

    public function edit($id)
    {
        $id         = Crypt::decrypt($id);
        $review     = SubscriberReviews::where("id", $id)->first();

        return view('admin.approval.reviews.details', compact('id', 'review'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $status             = $request->input('isValidate'); 

            if($status==2) {
                $job             = SubscriberReviews::find($id)->delete();
            }
            else {
                $job             = SubscriberReviews::find($id);
                $job->isActive   = $status;
                $job->save();
            }
            
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
