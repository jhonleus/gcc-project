<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourseBookmark extends Model
{
    protected $table   = 'user_courses_saved';

    /*get users details*/
	public function user() {
	    return $this->hasOne(SchoolCourse::class, 'id', 'courseId');
	}
}
