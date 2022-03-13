<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyLogo extends Model
{
    //
      protected $table   = 'company_logo';
      protected $fillable = [
        'photo_name'
    ];
}
