<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemUpdate extends Model
{
    //
     protected $table   = 'systemupdate';
      protected $fillable = [
        'email','message'
    ];
}
