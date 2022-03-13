<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class SubscriberAffilation extends Model
{
    protected $table   = 'subscriber_affilations';
    protected $fillable = ['usersId'];

    public function affilation() {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'usersId');
    }

    public function co_affilation() {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'companyId');
    }

    public function school() {
        return $this->hasOne(SchoolDetail::class, 'usersId', 'usersId');
    }

    public function co_school() {
        return $this->hasOne(SchoolDetail::class, 'usersId', 'companyId');
    }

    public function average() {
        $result =  $this->hasOne(SubscriberRatings::class, 'companyId', 'usersId')->select(DB::raw('avg(overall) average'))->groupBy('companyId')->first();

        if(!empty($result)) {
            return $result->average;
        }
        else {
            return 0;
        }
    }

    public function co_average() {
        $result =  $this->hasOne(SubscriberRatings::class, 'companyId', 'companyId')->select(DB::raw('avg(overall) average'))->groupBy('companyId')->first();

        if(!empty($result)) {
            return $result->average;
        }
        else {
            return 0;
        }
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'usersId');
    }

    public function co_user() {
        return $this->hasOne(User::class, 'id', 'companyId');
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function co_documents()
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'companyId');
    }
}
