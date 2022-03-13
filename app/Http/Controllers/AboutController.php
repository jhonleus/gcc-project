<?php

namespace App\Http\Controllers;
use App\CompanyLogo;
use App\MaintenanceAbout;
use App\UserLocale;
use App\MaintenanceLocale;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    public function index()
    {
        $about1 = MaintenanceAbout::where('id','1')->first();
        $about2 = MaintenanceAbout::where('id','2')->first();
        
        return view('front.about', compact('about1', 'about2'));
       
    }
}
