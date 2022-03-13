<?php

namespace App\Http\Controllers;
use App\CompanyLogo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CustomerService;
use App\Mail\Inquire;
use Alert;
use Mail;
use App\UserLocale;
use App\MaintenanceLocale;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        //fetching the customer service support data 
        $customerservicesupports = CustomerService::where('id','1')->get();


        //returning all the data to the contact page
        return view('front.contact', compact('customerservicesupports'));
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
        //validates all the input types in contact form
        $attributes = request()->validate([
        	'name'=> ['required', 'max:255'],
        	'phoneNumber'=> ['required', 'max:11'],
        	'email'=> ['required', 'max:255'],
        	'message'=> ['required', 'max:2500'],
        ]);

        //handling all the emails in input types
        $email = $request->input('email');

        //handling all the name in input types
        $name = $request->input('name');

        //handling all the message in input types
        $messages = $request->input('message');

        //handling all the phonenumber in input types
        $phoneNumber = $request->input('phoneNumber');

        $to_name = "Global Career Creation"; // NAME OF THE INQURIES HANDLING

        $to_email = "gcareercreation@gmail.com"; // EMAIL OF THE INQURIES HANDLING

        $data = array('body' => $messages, 'phone' => $phoneNumber); //Message and phone number of the user

        //sending function
        Mail::send('emails.inquire', $data, function($message) use ($email, $name, $to_name, $to_email) {

            $message->to($to_email, $to_name) //sending message to the gcc email account

            ->subject("Inquiries"); //the subject will show in the gmail 

            $message->from($email, $name); //the email and name of the one who sended the message
        });
       
        //after the message send it will return back to the contact page will success alert message
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