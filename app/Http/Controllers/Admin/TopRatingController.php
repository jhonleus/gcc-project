<?php

namespace App\Http\Controllers\Admin;
use App\EmployerDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use App\UserLocale;
use App\MaintenanceLocale;

class TopRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

        // $employer_ratings = EmployerRatings::all();

        $user = User::where('rolesId', '!=', 0)
        ->join('employer_details', 'users.id', '=', 'employer_details.usersId')
        ->join('subscriber_ratings', 'users.id', '=', 'subscriber_ratings.companyId')
        ->select(DB::raw('AVG(overall) as average, AVG(environment) as environment, AVG(career_growth) as career_growth , AVG(security) as security, AVG(relation) as relation, AVG(fees) as fees , employer_details.company, users.id' ))
        ->groupBy('employer_details.company')->groupBy('users.id')

        ->get();

        
    
        return view('admin.reports.toprating.index',compact('user'));
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
        //
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
        //
    }
}
