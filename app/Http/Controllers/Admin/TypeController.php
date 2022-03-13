<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\MaintenanceType;
use App\ExtraRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    public function index() {
        $types = MaintenanceType::all();
        $roles = ExtraRole::all();
        return view('admin.maintenance.type', compact('types', 'roles'));
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
                $check_value    = isset($_POST['isAll']) ? 1 : 0;

                $extra              = new MaintenanceType();
                $extra->roleId      = $request->get('role');
                $extra->name        = $request->get('name');
                $extra->isAll       = $check_value;
                $extra->save();

                DB::commit();

                alert()->success("SUCCESSFULLY ADDED");
                return redirect('admin/types');
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
                
                $check_value    = isset($_POST['isAll']) ? 1 : 0;
                $extra          = MaintenanceType::find($id);
                $extra->name    = $request->get('name');
                $extra->isAll   = $check_value;
                $extra->save();

                DB::commit();
                alert()->success("SUCCESSFULLY UPDATED");
                return redirect('admin/types');
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
    }

    public function destroy($id) {
        MaintenanceType::findOrFail($id)->delete();
        alert()->success("SUCCESSFULLY DELETED");
        return redirect('admin/types');
    }
}
