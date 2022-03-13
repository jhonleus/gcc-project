<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberReviews extends Model
{
	protected $table   = 'subscriber_reviews';

	public function users()
    {
        return $this->hasOne(User::class, 'id', 'companyId');
    }

    public function documents() {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function employer()
    {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'companyId');
    }

    public function school()
    {
        return $this->hasOne(SchoolDetail::class, 'usersId', 'companyId');
    }

    public function recommend()
    {
        if($this->recommend==0) {
            $msg = "Not recommended";
        }
        else{ 
            $msg = "Recommended";
        }

        return $msg;
    }
}
