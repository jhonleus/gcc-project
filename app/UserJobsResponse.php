<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserJobsResponse extends Model
{
    //
    protected $table   = 'user_jobs_response';
    protected $fillable = ['jobApplicationId'];
}
