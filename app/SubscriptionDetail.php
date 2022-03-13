<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionDetail extends Model
{
    //
    protected $fillable = [
    	'subscriptionId', 'price', 'countryId'
    ];
}
