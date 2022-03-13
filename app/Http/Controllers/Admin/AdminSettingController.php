<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\UserLocale;
use App\MaintenanceLocale;

class AdminSettingController extends Controller
{
    //
   public function index()
   {   
    
    return view('admin.adminsettings.index');
}

public function store(Request $request){

            //this will validate the current password
   $request->validate([

            //the current password of the user    
    'current_password' => ['required', new MatchOldPassword],

            //new password of the user
    'new_password' => ['required'],

            //validate if the new password is correct
    'new_confirm_password' => ['same:new_password'],
    ]);


   DB::beginTransaction();
   try {
    
    User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
    
            //if the updating process is successfull alert will pop up
    alert()->success(MaintenanceLocale::getLocale(258),'');

    return redirect('admin/password');
}
catch (\Exception $ex) {
    DB::rollback();
    return response()->json(['error' => $ex->getMessage()], 500);
}
}
}
