<?php

namespace App\Http\Controllers;
use App\CompanyLogo;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    //
    public function index()
    {

        //returning the data to the companies page
        return view('front.companies');
        
    }
}
