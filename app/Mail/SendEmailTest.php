<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class SendEmailTest extends Mailable {
    use Queueable, SerializesModels;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $details;

    public function __construct($details) {
          $this->details = $details;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        if($this->details['count'] > 1) {
            return $this->view('emails.template')
                    ->subject($this->details['subject'])
                    ->attach(public_path($this->details['location'].$this->details['pathName']), [
                        'as'    => $this->details['pathName'],
                        'mime'  => $this->details['contentType'],
                    ])
                    ->attach(public_path($this->details['location'].$this->details['pathName1']), [
                        'as'    => $this->details['pathName1'],
                        'mime'  => $this->details['contentType1'],
                    ])
                    ->with([
                        'fullname'  => $this->details['fullName'],
                        'body'      => $this->details['body'],
                        'actions'   => $this->details['actions']
                    ]);
        }
        else {
            return $this->view('emails.template')
                    ->subject($this->details['subject'])
                    ->attach(public_path($this->details['location'].$this->details['pathName']), [
                        'as'    => $this->details['pathName'],
                        'mime'  => $this->details['contentType'],
                    ])
                    ->with([
                        'fullname'  => $this->details['fullName'],
                        'body'      => $this->details['body'],
                        'actions'   => $this->details['actions']
                    ]);
        }
    }
        
}