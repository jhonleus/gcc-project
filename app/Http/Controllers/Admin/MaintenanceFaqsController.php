<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\MaintenanceFaqs;
use App\CompanyLogo;
use DB;
use Illuminate\Http\Request;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;

class MaintenanceFaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $maintenance_faqs 	= MaintenanceFaqs::all();
          
        return view('admin.maintenance.faqs', compact('maintenance_faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.maintenance.faqs_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $faqs 			= new MaintenanceFaqs();
            $faqs->question = $request->input('question');
            $faqs->answer 	= $request->input('answer');
            $faqs->status 	= "1";
        
            $faqs->save();
        
            DB::commit();
        } 

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        alert()->success(MaintenanceLocale::getLocale(257),'');

        return redirect('admin/faq');
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
        $faqs = MaintenanceFaqs::where('id', $id)->first();

        return view('admin.maintenance.faqs_create', compact('faqs'));
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
        DB::beginTransaction();
        try {
            $faqs 			= MaintenanceFaqs::find($id);
            $faqs->question = $request->get('question');
            $faqs->answer 	= $request->get('answer');

            $faqs->save();

            DB::commit();
            alert()->success(MaintenanceLocale::getLocale(258),'');
            return redirect('admin/faq');
        } 

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MaintenanceFaqs::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('admin/faq');
    }
}
