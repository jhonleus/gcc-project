<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPrelocation extends Model
{
    public $timestamps = false;

    public function location()
    {
        return $this->hasOne(ExtraCountry::class, 'id', 'countryId');
    }
}
