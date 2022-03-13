<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerAgencies extends Model {
   	protected $table   = 'employer_agencies';
    protected $fillable = ['usersId'];

    public function employers() {
        return $this->hasOne(EmployerDetail::class, 'usersId', 'usersId');
    }

    public function users() {
        return $this->hasOne(User::class, 'id', 'organizationId');
    }
}
