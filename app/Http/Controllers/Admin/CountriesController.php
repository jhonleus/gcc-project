<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\ExtraCountry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserLocale;
use App\MaintenanceLocale;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extras = ExtraCountry::all();
        return view('admin.maintenance.countries', compact('extras'));
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

                $extra = new ExtraCountry();
                $extra->iso = $request->get('iso');
                $extra->name = $request->get('name');
                $extra->nicename = $request->get('nicename');
                $extra->iso3 = $request->get('iso3');
                $extra->numcode = $request->get('numcode');
                $extra->phonecode = $request->get('phonecode');
                $extra->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(257),'');
            return redirect('admin/countries');

        // UPDATE EXISTING
        } else if ($request->has($request['btnUpdate'])) {

            DB::beginTransaction();
            try {

                $id = $request->get('id');

                $extra = ExtraCountry::find($id);
                $extra->iso = $request->get('iso');
                $extra->name = $request->get('name');
                $extra->nicename = $request->get('nicename');
                $extra->iso3 = $request->get('iso3');
                $extra->numcode = $request->get('numcode');
                $extra->phonecode = $request->get('phonecode');
                $extra->save();
                

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success(MaintenanceLocale::getLocale(258),'');
            return redirect('admin/countries');

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
        ExtraCountry::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('admin/countries');
    }
}
