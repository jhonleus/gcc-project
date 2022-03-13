<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBookmark extends Model
{
    protected $fillable = ['usersId'];

    public function bookmark()
    {
        return $this->hasOne(EmployerJob::class, 'id', 'jobId');
    }
}
