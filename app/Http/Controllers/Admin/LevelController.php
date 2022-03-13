<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\ExtraLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserLocale;
use App\MaintenanceLocale;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $extras = ExtraLevel::all();
        return view('admin.maintenance.attainment', compact('extras'));
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
        // CREATE NEW ONE
        if ($request->has($request['btnAdd'])) {

            DB::beginTransaction();
            try {

                $extra = new ExtraLevel();
                $extra->name = $request->get('name');
                $extra->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(257),'');
            return redirect('admin/attainment');

        // UPDATE EXISTING
        } else if ($request->has($request['btnUpdate'])) {

            DB::beginTransaction();
            try {

                $id = $request->get('id');

                $extra = ExtraLevel::find($id);
                $extra->name = $request->get('name');
                $extra->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(258),'');
            return redirect('admin/attainment');

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
        ExtraLevel::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('admin/attainment');
    }
}
