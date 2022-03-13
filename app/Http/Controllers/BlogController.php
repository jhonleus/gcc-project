<?php

namespace App\Http\Controllers;
use App\MaintenanceBlog;
use Illuminate\Http\Request;
use DB;
use App\CompanyLogo;
use App\UserLocale;
use App\MaintenanceLocale;

class BlogController extends Controller
{
    //
     public function index()
    {

        $blogs = MaintenanceBlog::with('users')->where("status", 1)->orderBy('id', 'desc')->paginate(6);

        return view('front.blog', compact('blogs'));
 
    }

    public function show($id)
    {   
        //fetching the specific data from the maintenance blog table
        $blogs = MaintenanceBlog::with('users')->where('id', $id)->first();

        return view('front.blogcontent', compact('blogs'));
    }

    public function destroy($id)
    {
        //
    }
}
