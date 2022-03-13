<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    protected $table   = 'user_invitations';

    public function jobs()
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

    public function eaddress()
    {
        return $this->hasOne(UserAddress::class, 'usersId', 'companyId');
    }

    public function documents()   
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function tattoos() {
        return $this->hasMany(UserDocument::class, 'usersId', 'id')->where("filetype", "tattoo")->get();
    }

    public function certificates() {
        return $this->hasMany(UserCertification::class, 'usersId', 'id')
            ->where(function ($query) {
                $query->where('type', "N1")
                      ->orWhere('type', "N2")
                      ->orWhere('type', "N3")
                      ->orWhere('type', "N4")
                      ->orWhere('type', "N5")
                      ->orWhere('type', "Others");
            })->get();
    }

    public function educations() {
        return $this->hasMany(UserEducation::class, 'usersId', 'id');
    }

    public function employer() {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'companyId');
    }
}
