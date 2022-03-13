<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class EmployerDetail extends Model
{
    protected $fillable = ['usersId'];

    public function jobs()
    {
        return $this->hasOne(EmployerJob::class, 'usersId', 'usersId');
    }

    public function subscriptions()
    {
        return $this->hasOne(EmployerPayment::class, 'id');
    }

    public function files()
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function subscription()
    {
        return $this->hasOne(SubscriptionDetails::class, 'id', 'subscriptionDetailsId');
    }

    public function ratings()
    {
        return $this->hasOne(EmployerRatings::class, 'employer_id');
    }

    public function industry()
    {
        return $this->hasOne(ExtraIndustry::class, 'id', 'industryId');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'usersId', 'usersId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'usersId');
    }

    public function type()
    {
        return $this->hasOne(MaintenanceType::class, 'id', 'typeId');
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
}
