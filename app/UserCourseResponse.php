<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourseResponse extends Model
{
    protected $table   = 'user_courses_response';
    protected $fillable = ['courseApplicationId'];

	public function course() {
        return $this->hasOne(UserCourses::class, 'id', 'courseApplicationId');
    }
}
