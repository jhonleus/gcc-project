<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourses extends Model
{
	protected $table   = 'user_courses_application';
	protected $fillable = [
		'usersId', 'courseId', 'companyId', 'path', 'filename'
	];

	/*get course details*/
	public function course() {
	    return $this->hasOne(SchoolCourse::class, 'id', 'courseId');
	}
	public function response() {
        return $this->hasOne(UserCourseResponse::class, 'courseApplicationId', 'id');
    }

	/*get school details*/
	public function school() {
	    return $this->hasOne(SchoolDetail::class, 'usersId', 'companyId');
	}

	public function users() {
	    return $this->hasOne(User::class, 'id', 'companyId');
	}

	/*get users details*/
	public function user() {
	    return $this->hasOne(User::class, 'id', 'usersId');
	}
	public function detail() {
	    return $this->hasOne(UserDetail::class, 'usersId', 'usersId');
	}
	public function contact() {
        return $this->hasOne(UserContact::class, 'usersId', 'usersId');
    }
    public function address() {
        return $this->hasOne(UserAddress::class, 'usersId', 'usersId');
    }
    public function documents() {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }
    public function company_documents() {
        return $this->hasMany(UserDocument::class, 'usersId', 'companyId');
    }
}
