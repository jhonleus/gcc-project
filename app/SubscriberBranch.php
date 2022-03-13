<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberBranch extends Model
{
    protected $table   = 'subscriber_branch';
    protected $fillable = ['usersId'];

    public function country()
    {
        return $this->hasOne(ExtraCountry::class, 'id', 'countryId');
    }
}
