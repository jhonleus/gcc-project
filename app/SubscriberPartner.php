<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberPartner extends Model
{
    protected $table   = 'subscriber_partners';
    protected $fillable = ['usersId'];

    public function partner() {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'usersId');
    }

    public function co_partner() {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'companyId');
    }

    public function school() {
        return $this->hasOne(SchoolDetail::class, 'usersId', 'usersId');
    }

    public function co_school() {
        return $this->hasOne(SchoolDetail::class, 'usersId', 'companyId');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'usersId');
    }

    public function co_user() {
        return $this->hasOne(User::class, 'id', 'companyId');
    }
}
