<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
    	if (\Schema::hasTable('customerservicesupports')) {
        	$mail = DB::table('customerservicesupports')->first();
        	if($mail) {
	         	$emailAddress 	= explode("@", $mail->email);
	         	$username 		= $emailAddress[0];

	 	        $config = array(
	 	            'driver'     => "smtp",
	 	            'host'       => "smtp.googlemail.com",
	 	            'port'       => "465",
	 	            'from'       => array('address' => $mail->email, 'name' => "Global Career Creation"),
	 	            'encryption' => "ssl",
	 	            'username'   => $username,
	 	            'password'   => $mail->password,
	 	            'sendmail'   => '/usr/sbin/sendmail -bs',
	 	            'pretend'    => false,
	 	        );
	 	        Config::set('mail', $config);
        	}
	    }
    }
}