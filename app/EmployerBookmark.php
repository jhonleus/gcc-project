<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerBookmark extends Model
{
    protected $table   = 'employer_bookmarks';

    public function applicant()
    {
        return $this->hasOne(User::class, 'id', 'applicantId');
    }

	public function details()
	{
	    return $this->hasOne(UserDetail::class, 'usersId', 'applicantId');
	}

	public function contacts()
    {
        return $this->hasOne(UserContact::class, 'usersId', 'applicantId');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'usersId', 'applicantId');
    }

    public function documents()   
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'applicantId');
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
}
