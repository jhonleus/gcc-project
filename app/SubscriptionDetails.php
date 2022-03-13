<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionDetails extends Model
{
    protected $table   = 'subscriber_details';
    protected $fillable = [
        'usersId', 'subscriptionId', 'first_day', 'last_day'
    ];

    public function subscription()
    {
        return $this->hasOne(MaintenanceSubscriptions::class, 'id', 'subscriptionId');
    }

    public function payment()
    {
        return $this->hasOne(PaymentDetails::class, 'id', 'paymentid');
    }

    public function otc()
    {
        return $this->hasOne(SubscriberOtc::class, 'id', 'paymentid');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'usersId');
    }

    public function employer()
    {
        return $this->hasOne(User::class, 'id', 'usersId');
    }
}
