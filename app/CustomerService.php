<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    //
     protected $table   = 'customerservicesupports';
      protected $fillable = [
        'email','password', 'address','phone','telephone'
    ];
}
