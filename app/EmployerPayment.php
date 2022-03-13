<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerPayment extends Model
{
    public function subscription()
    {
        return $this->hasOne(MaintenanceSubscriptions::class, 'id', 'subscriptionId');
    }
}
