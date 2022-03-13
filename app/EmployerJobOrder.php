<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerJobOrder extends Model
{
    protected $table   = 'employer_job_order';
    protected $fillable = ['usersId', 'jobId'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'partnersId');
    }
}
