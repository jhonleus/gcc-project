<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class SchoolCourse extends Model
{
    public function country()
    {
        return $this->hasOne(ExtraCountry::class, 'id', 'locationId');
    }

    public function documents()   
    {
        return $this->hasMany(UserDocument::class, 'usersId', 'usersId');
    }

    public function employers()
    {
        return $this->hasOne(SchoolDetail::class, 'usersId', 'usersId');
    }

    public function specializations()
    {
        return $this->hasOne(ExtraStudentSpecialization::class, 'id', 'specializationId');
    }

    public function currency()
    {
        return $this->hasOne(ExtraCurrency::class, 'id', 'currencyId');
    }

    public function schedules() {
        return $this->hasMany(SchoolCourseSchedule::class, 'courseId', 'id');
    }

    public function interview() {
        return $this->hasMany(UserCourses::class, 'courseId', 'id')
            ->where("status", 2)->count();
    }

    public function unprocessed() {
        return $this->hasMany(UserCourses::class, 'courseId', 'id')
            ->where("status", 1)->count();
    }

    public function rejected() {
        return $this->hasMany(UserCourses::class, 'courseId', 'id')
            ->where("status", 0)->count();
    }

    public function average() {
        $result =  $this->hasOne(SubscriberRatings::class, 'companyId', 'usersId')
                    ->select(DB::raw('avg(overall) average'))
                    ->groupBy('companyId')->first();

        if(!empty($result)) {
            return $result->average;
        }
        else {
            return 0;
        }
    }
}
