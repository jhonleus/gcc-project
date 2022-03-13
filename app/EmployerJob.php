<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class EmployerJob extends Model
{

    public function country()
    {
        return $this->hasOne(ExtraCountry::class, 'id', 'locationId');
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function employers()
    {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'usersId');
    }

    public function average() {
        $result =  $this->hasOne(SubscriberRatings::class, 'companyId', 'usersId')
        			->select(DB::raw('avg(overall) average'))
   					->groupBy('companyId')->first();

   		if(!empty($result)) {
   			return $result->average;
   		}
   		else {
   			return 0;
   		}
    }

    public function employments()
    {
        return $this->hasOne(ExtraEmployment::class, 'id', 'employmentId');
    }

    public function positions()
    {
        return $this->hasOne(ExtraPosition::class, 'id', 'positionId');
    }

    public function currency()
    {
        return $this->hasOne(ExtraCurrency::class, 'id', 'currencyId');
    }

    public function specializations()
    {
        return $this->hasOne(ExtraSpecialization::class, 'id', 'specializationId');
    }

    public function info()
	{
	    return $this->hasOne(User::class, 'id', 'usersId');
	}

    public function interview() {
        return $this->hasMany(UserApplication::class, 'jobId', 'id')
            ->where("status", 2)->count();
    }

    public function unprocessed() {
        return $this->hasMany(UserApplication::class, 'jobId', 'id')
            ->where("status", 1)->count();
    }

    public function rejected() {
        return $this->hasMany(UserApplication::class, 'jobId', 'id')
            ->where("status", 3)->count();
    }

    public function order() {
        return $this->hasOne(EmployerJobOrder::class, 'jobId', 'id');
    }
}

