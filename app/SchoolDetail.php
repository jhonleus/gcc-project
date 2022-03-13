<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolDetail extends Model
{
    protected $table   = 'school_details';
    protected $fillable = [
        'usersId'
    ];

    public function courses()
    {
        return $this->hasMany(SchoolCourse::class, 'usersId', 'usersId');
    }

    public function reviews()
    {
        return $this->hasMany(SchoolDetail::class, 'usersId', 'usersId');
    }

    public function subscription()
    {
        return $this->hasOne(SubscriptionDetails::class, 'id', 'subscriptionDetailsId');
    }

    public function subscriptions()
    {
        return $this->hasMany(SubscriptionDetails::class, 'usersId', 'usersId');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'usersId', 'usersId');
    }

    public function files()
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function type()
    {
        return $this->hasOne(MaintenanceType::class, 'id', 'typeId');
    }
}
