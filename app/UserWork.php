<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{
    protected $fillable = ['usersId'];
    public $timestamps = false;

    public function country()
    {
        return $this->hasOne(ExtraCountry::class, 'id', 'countryId');
    }
}
