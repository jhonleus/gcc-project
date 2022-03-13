<?php

namespace App\Http\Controllers\Admin;

use App\EmployerJob;
use App\SchoolCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostedController extends Controller
{

    public function jobs()
    {
        $jobs = EmployerJob::orderBy('id', 'desc')->get();

        return view("admin.posted.jobs", compact('jobs'));
    }

    public function courses()
    {
        $courses = SchoolCourse::orderBy('id', 'desc')->get();

        return view("admin.posted.courses", compact('courses'));
    }

}
