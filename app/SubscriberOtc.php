<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberOtc extends Model
{
    public function subscriptions()
    {
        return $this->hasOne(MaintenanceSubscriptions::class, 'id', 'subscriptionId');
    }

    public function banks()
    {
        return $this->hasOne(ExtraBank::class, 'id', 'bankId');
    }

    public function employers()
    {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'usersId');
    }
}
