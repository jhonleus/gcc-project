<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\MaintenanceResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function index() {
        $results = MaintenanceResult::all();
        return view('admin.maintenance.results', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($request->has($request['btnAdd'])) {
            DB::beginTransaction();
            try {

                $extra              = new MaintenanceResult();
                $extra->name        = $request->get('name');
                $extra->save();

                DB::commit();

                alert()->success("SUCCESSFULLY ADDED");
                return redirect('admin/results');
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        } 

        else if ($request->has($request['btnUpdate'])) {
            DB::beginTransaction();
            try {
                $id  = $request->get('id');
                
                $extra          = MaintenanceResult::find($id);
                $extra->name    = $request->get('name');
                $extra->save();

                DB::commit();
                alert()->success("SUCCESSFULLY UPDATED");
                return redirect('admin/results');
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
    }

    public function destroy($id) {
        MaintenanceResult::findOrFail($id)->delete();
        alert()->success("SUCCESSFULLY DELETED");
        return redirect('admin/results');
    }
}
