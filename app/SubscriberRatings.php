<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberRatings extends Model
{
    protected $table   = 'subscriber_ratings';

    public function employers()
    {
        return $this->hasOne(EmployerDetail::class,'id','usersId');
    }

    public function schools()
    {
        return $this->hasOne(SchoolDetail::class,'id','usersId');
    }
}
