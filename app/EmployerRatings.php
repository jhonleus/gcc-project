<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerRatings extends Model
{
    protected $table   = 'employer_ratings';
    protected $fillable = [
    	'employer_id', 'work_environment_rate', 'career_growth_rate', 'job_security_rate', 'employee_relation_rate', 'overall_rate'
    ];
}
