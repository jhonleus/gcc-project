<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Braintree;

class Plan extends Model
{
    //
    protected $fillable = ['name', 'slug', 'braintree_plan', 'cost', 'description'];

    public static function gateway(){
		$gateway = new Braintree\Gateway([
	      'environment' => env('BRAINTREE_ENV'),
	      'merchantId' => env('BRAINTREE_MERCHANT_ID'),
	      'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
	      'privateKey' => env('BRAINTREE_PRIVATE_KEY')
	      ]);

		return $gateway;
	}
}
