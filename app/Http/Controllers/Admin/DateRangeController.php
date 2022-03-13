<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserLocale;
use App\MaintenanceLocale;

class DateRangeController extends Controller
{
 
 function index(Request $request)
 {
     if(request()->ajax())
     {
      if(!empty($request->from_date))
      {
      //getting all data from sales table	
       $data = DB::table('sales')
         ->whereBetween('created_at', array($request->from_date, $request->to_date))
         ->get();
      }
      else
      {
       $data = DB::table('sales')
         ->get();
      }
      return datatables()->of($data)->make(true);
     }


     //return the data value in daterange page
     return view('admin.reports.daterange');
    }
    
}
