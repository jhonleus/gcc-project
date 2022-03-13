<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['usersId'];
    public $timestamps = false;


    public function results()
    {
        return $this->hasOne(MaintenanceResult::class, 'id', 'result');
    }
    
    public function genders()
    {
        return $this->hasOne(ExtraGender::class, 'id', 'genderId');
    }

    public function civils()
    {
        return $this->hasOne(ExtraCivil::class, 'id', 'civilId');
    }

    public function religions()
    {
        return $this->hasOne(ExtraReligion::class, 'id', 'religionId');
    }

    public function currency()
    {
        return $this->hasOne(ExtraCurrency::class, 'id', 'currencyId');
    }

    public function users() {
        return $this->hasOne(User::class, 'id', 'usersId');
    }

    public function files() {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function type()
    {
        return $this->hasOne(MaintenanceType::class, 'id', 'typeId');
    }
}
