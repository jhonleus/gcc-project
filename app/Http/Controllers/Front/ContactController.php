<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Mail\Inquire;
use Alert;
use Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //

        return view('front.contact');
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
        $attributes = request()->validate([
        	'name'=> ['required', 'max:255'],
        	'phoneNumber'=> ['required', 'max:11'],
        	'email'=> ['required', 'max:255'],
        	'message'=> ['required', 'max:2500'],
        ]);

        $email = $request->input('email');
        $name = $request->input('name');
        $messages = $request->input('message');
        $phoneNumber = $request->input('phoneNumber');

        $to_name = "Global Career Creation"; // NAME OF THE INQURIES HANDLING
        $to_email = "test.gcc000@gmail.com"; // EMAIL OF THE INQURIES HANDLING
        $data = array('body' => $messages, 'phone' => $phoneNumber);
        Mail::send('emails.inquire', $data, function($message) use ($email, $name, $to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject("Inquiries");
            $message->from($email, $name);
        });
       
        return redirect()->route('contact.index')->with(['success'=>'Sent Email Successfully!']);

        /*
        
        \Mail::to($email)->send(new Inquire);
        alert()->success('Title','Lorem Lorem Lorem');
        return redirect('contact');
        */
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
