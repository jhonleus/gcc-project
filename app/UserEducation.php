<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    protected $fillable = ['usersId'];
    public $timestamps = false;

    public function levels()
    {
        return $this->hasOne(ExtraLevel::class, 'id', 'levelId');
    }

    public function country()
    {
        return $this->hasOne(ExtraCountry::class, 'id', 'countryId');
    }
}
