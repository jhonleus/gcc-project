<?php

namespace App\Http\Controllers\Admin;
use App\Mail\Inquire;
use DB;
use App\User;
use Illuminate\Http\Request;
use App\SystemUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;

class SystemUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
      //fetching the users table
      $users = User::all();

      //return the data to systemupdate page
      return view('admin.systemupdate.index',compact('users'));
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
      
      $messages = $request->input('message');
      $users = User::all();

      // SENDING MESSAGE TO ALL REGISTERED USERS
      foreach ($users as $user) {

        // SENDING FUNCTIONALITY
        Mail::send('emails.systemupdate', ['body' => $messages, 'name' => $user->firstName],
          function ($message) use ($user) {

              // MESSAGE SUBJECT
              $message->subject('Global Careers Creation Updates');

              // MESSAGE THAT WILL BE SENT
              $message->to($user['email']);
        });
      }

      //if the message send successfully alert will pop up
      alert()->success('Success','Sended successfully!');
      
      //this wil redirect to systemupdate page
      return redirect('admin/systemupdate');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SystemUpdate  $systemUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(SystemUpdate $systemUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SystemUpdate  $systemUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemUpdate $systemUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SystemUpdate  $systemUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemUpdate $systemUpdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SystemUpdate  $systemUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemUpdate $systemUpdate)
    {
        //
    }
}
