<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\SendEmailJob;
use App\SubscriberAffilation;
use Mail;
use Auth;

class EmailModel extends Model
{
	/*send the email*/
    public static function sendEmail($email) {
        /*sender info*/
        $sender_name 	= "Global Career Creation"; 
        $sender_email 	= "test.gcc000@gmail.com"; 

        /*receiver info*/
        $receiver_email = $email['receiver_email']; 
        $receiver_name 	= $email['receiver_name'];	

        /*message body*/
        $messages 	= $email['message']; 

        /*subject of the email*/
        $subject 	= $email['subject'];

        if(isset($email['actions'])) {
        	$actions = $email['actions'];
        }
        else {
        	$actions = "";
        }

        $data = array('body' => $messages, 'fullname' => $receiver_name, 'actions' => $actions); 
        try {
	        /*send the email*/
	        Mail::send('emails.template', $data, function($message) use ($sender_email, $sender_name, $receiver_name, $receiver_email, $subject) {
	            $message->to($receiver_email, $receiver_name) 
	            ->subject($subject);
	            $message->from($sender_email, $sender_name); 
	        });
	    }

	    catch (\Exception $ex) {
   		    return response()->json(['result' => $ex->getMessage()], 500);
   		}
    }

    public static function sendAffilations($data) {

        $companyId          = $data['companyId'];
        $companyName        = $data['companyName'];
        $applicationName    = $data['applicationName'];
        $location_1         = $data['location_1'];
        $fileName           = $data['fileName'];
        $contentType        = $data['contentType'];


        $affilations = SubscriberAffilation::where('isActive', 1)->where(function($q) use($companyId) {
                $q->where('companyId', $companyId)->orWhere('usersId', $companyId);
            })->get();

        foreach ($affilations as $key => $affilation) {

            $sender_name    = "Global Career Creation"; 
            $sender_email   = "test.gcc000@gmail.com"; 
            $subject = "New Application for " . $companyName;
            $messages = Auth::user()->firstName . " " . Auth::user()->lastName . " applied to ". $applicationName;

            if($affilation->usersId == $companyId) {

                $receiver_name = $affilation->co_user->firstName;
                $receiver_email = $affilation->co_user->email;

            }
            else {

                $receiver_name = $affilation->user->firstName;
                $receiver_email = $affilation->user->email;

            }

            $data = array('body' => $messages, 'fullname' => $receiver_name, 'actions' => ""); 

            Mail::send('emails.template', $data, function($message) use ($sender_email, $sender_name, $receiver_name, $receiver_email, $subject, $location_1, $fileName, $contentType) {
                $message->to($receiver_email, $receiver_name) 
                ->subject($subject)
                ->attach(public_path($location_1.$fileName), [
                    'as'    => $fileName,
                    'mime'  => $contentType,
                ]);
            });

        }

    }
}
