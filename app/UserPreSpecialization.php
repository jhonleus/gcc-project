<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPreSpecialization extends Model
{
    public $timestamps = false;

    public function specialization()
    {
        return $this->hasOne(ExtraSpecialization::class, 'id', 'specializationId');
    }

    public function applicant()
    {
        return $this->hasOne(User::class, 'id', 'usersId');
    }

	public function details()
	{
	    return $this->hasOne(UserDetail::class, 'usersId', 'usersId');
	}

	public function contacts()
    {
        return $this->hasOne(UserContact::class, 'usersId', 'usersId');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'usersId', 'usersId');
    }

    public function documents()   
    {
        return $this->hasOne(UserDocument::class, 'usersId', 'usersId');
    }
}
