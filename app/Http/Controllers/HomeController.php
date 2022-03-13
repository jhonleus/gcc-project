<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserLocale;
use App\MaintenanceNda;
use DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $users = User::whereHas('roles')->find(1);
        //return view('front.index');
        return view('admin.index');
    }

    public function locale($id)
    {
        DB::beginTransaction();
        try {
           
            $locale = UserLocale::firstOrNew(array('token' => csrf_token()));
            $locale->token = csrf_token();
            $locale->locale = $id;
            $locale->save();
        
            DB::commit();
            return back();
        }

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function nda()
    {
        $documents = MaintenanceNda::where('id', 1)->first();

        $file_path = public_path('nda/'.$documents->file);
        $replace = str_replace('/', "\'", $file_path);
        $final = str_replace("'", "", $replace);

        
        return response()->download($final);
    }
}
