<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\ExtraBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MaintenanceLocale;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extras = ExtraBank::all();
        return view('admin.maintenance.bank', compact('extras'));
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

                $extra = new ExtraBank();
                $extra->bank = $request->get('bank');
                $extra->number = $request->get('number');
                $extra->name = $request->get('name');
                $extra->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(257),'');
            return redirect('admin/banks');

        // UPDATE EXISTING
        } else if ($request->has($request['btnUpdate'])) {

            DB::beginTransaction();
            try {

                $id = $request->get('id');

                $extra = ExtraBank::find($id);
                $extra->bank = $request->get('bank');
                $extra->number = $request->get('number');
                $extra->name = $request->get('name');
                $extra->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(258),'');
            return redirect('admin/banks');

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
        ExtraBank::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('admin/banks');
    }
}
