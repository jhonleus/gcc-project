<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerReviews extends Model
{
    protected $table   = 'employer_reviews';
    protected $fillable = [
    	'summary', 'review', 'pros', 'cons', 'overall_rating', 'recommend', 'salary_rate', 'employeeid'
    ];
}
