<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use App\Feedback;
use App\CompanyLogo;
use Illuminate\Http\Request;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
    
        //fetching the feedbacks data table
        $feedbacks = Feedback::all();

        //returning all the data to feedback page
        return view('front.feedback',compact('feedbacks'));
    }

    public function testimony()
    {   

        //if the feedbacks of the user is approved by the admin it will show to the testimony page
        $feedbacks = Feedback::where('status','1')->paginate(5);
  
        //returning all the data to the testimony page
        return view('front.testimony',compact('feedbacks'));
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

        //making the feedbacks as variable of feedback model
        $feedbacks = new Feedback();

        //this is the one who handles the email of the user
        $feedbacks->name = $request->input('name');
        $feedbacks->work = $request->input('work');

        //this is the one who handles the message of the user
        $feedbacks->message = $request->input('message');

        //saving all the data from feedback page 
        $feedbacks->save();

        //if the submition of data is correct and done this will popup
        alert()->success('SUCCESSFULLY SUBMITTED', 'Thank you for your feedback. We will process your feedback as soon as possible.');

        //and will redirect back to the feedback page
        return redirect('/feedback');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
