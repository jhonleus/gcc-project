<?php

namespace App\Http\Controllers;

use App\FeedBacksModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedBacksController extends Controller
{
    public function __construct() {
      //  $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $id = 1;
         //$feedbacks = FeedBack::latest()->paginate(5);
          $feedbacks = FeedBacksModel::where('id', $id)->with('name')->get();
       // return view('feedbacks.index',compact('feedbacks'))
     //       ->with('i', (request()->input('page', 1) - 1) * 5);

        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
  
        FeedBack::create($request->all());
   
        return redirect()->route('feedbacks.index')
                        ->with('success','Feedback created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FeedBack  $feedBack
     * @return \Illuminate\Http\Response
     */
    public function show(FeedBack $FeedBack)
    {
         return view('feedbacks.show',compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FeedBack  $feedBack
     * @return \Illuminate\Http\Response
     */
    public function edit(FeedBack $FeedBack)
    {
         return view('feedbacks.edit',compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FeedBack  $feedBack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeedBack $FeedBack)
    {
         $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
  
        $feedback->update($request->all());
  
        return redirect()->route('feedbacks.index')
                        ->with('success','Feedback updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FeedBack  $feedBack
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeedBack $FeedBack)
    {
         $feedback->delete();
  
        return redirect()->route('feedbacks.index')
                        ->with('success','Feedback deleted successfully');
    }
}
