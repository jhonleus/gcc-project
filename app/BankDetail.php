<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    //
      protected $table   = 'maintenance_bankdetails';
      protected $fillable = [
        'account_number','account_name','expiration','cvv'
    ];
}
