<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;

class FeedbacklistController extends Controller
{

	public function index()
	{   

		$pendings = Feedback::where("status", 0)->orderBy('id', 'desc')->get();
		$approveds = Feedback::where("status", 1)->where("selected", 0)->orderBy('id', 'desc')->get();
		$rejecteds = Feedback::where("status", 2)->orderBy('id', 'desc')->get();
		$displayeds = Feedback::where("status", 1)->where("selected", 1)->orderBy('id', 'desc')->get();

        //after getting all the data from the table, it will return the data to the blade
		return view('admin.feedback.index', compact('pendings', 'approveds', 'rejecteds', 'displayeds'));
	}

	public function update(Request $request, $id)
	{   
        // ******************** APPROVE **************************
		if ($request->has($request['btnApprove'])) {

			DB::beginTransaction();
			try {
				
				$feedback = Feedback::find($id);
				$feedback->status = 1;
				$feedback->save();

				DB::commit();

				alert()->success(MaintenanceLocale::getLocale(247),'');
				return redirect('admin/feedback');

			} catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['error' => $ex->getMessage()], 500);
			}

        // ******************** REJECT **************************
		} if ($request->has($request['btnReject'])) {

			DB::beginTransaction();
			try {
				
				$feedback = Feedback::find($id);
				$feedback->status = 2;
				$feedback->save();

				DB::commit();

				alert()->success(MaintenanceLocale::getLocale(246),'');
				return redirect('admin/feedback');

			} catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['error' => $ex->getMessage()], 500);
			}
			
        // ******************** MOVE TO PENDING **************************
		} if ($request->has($request['btnPending'])) {

			DB::beginTransaction();
			try {
				
				$feedback = Feedback::find($id);
				$feedback->status = 0;
				$feedback->save();

				DB::commit();

				alert()->success(MaintenanceLocale::getLocale(266),'');
				return redirect('admin/feedback');

			} catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['error' => $ex->getMessage()], 500);
			}
			
        // ******************** DISPLAY **************************
		} if ($request->has($request['btnDisplay'])) {

			$displayeds = Feedback::where("status", 1)->where("selected", 1)->get();
			$total_display = $displayeds->count();

			if ($total_display >= 5) {

				alert()->error(MaintenanceLocale::getLocale(267),'');
				return redirect('admin/feedback');

			} else {

				DB::beginTransaction();
				try {
					
					$feedback = Feedback::find($id);
					$feedback->selected = 1;
					$feedback->save();
					
					DB::commit();
					
					alert()->success(MaintenanceLocale::getLocale(268),'');
					return redirect('admin/feedback');
					
				} catch (\Exception $ex) {
					DB::rollback();
					return response()->json(['error' => $ex->getMessage()], 500);
				}

			}
			
        // ******************** UNDISPLAY **************************
		} if ($request->has($request['btnUnDisplay'])) {

			DB::beginTransaction();
			try {
				
				$feedback = Feedback::find($id);
				$feedback->selected = 0;
				$feedback->save();

				DB::commit();

				alert()->success(MaintenanceLocale::getLocale(269),'');
				return redirect('admin/feedback');

			} catch (\Exception $ex) {
				DB::rollback();
				return response()->json(['error' => $ex->getMessage()], 500);
			}
		}
	}

	public function destroy($id)
	{   
        
	}

}
