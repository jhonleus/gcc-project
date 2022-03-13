<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApplication extends Model
{
	public function employer()
    {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'companyId');
    }

    public function employerd()
    {
        return $this->hasOne(User::class, 'id', 'companyId');
    }

    public function response() {
        return $this->hasOne(UserJobsResponse::class, 'jobApplicationId', 'id');
    }

    public function application()
    {
        return $this->hasOne(EmployerJob::class, 'id', 'jobId');
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
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function company_documents() {
        return $this->hasMany(UserDocument::class, 'usersId', 'companyId');
    }

    public function location() {
        return $this->hasMany(UserPrelocation::class, 'usersId', 'usersId');
    }

    public function works() {
        return $this->hasMany(UserWork::class, 'usersId', 'usersId');
    }

    public function specialization() {
        return $this->hasMany(UserPreSpecialization::class, 'usersId', 'usersId');
    }
}
