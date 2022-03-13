<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCertification extends Model
{
    protected $table   = 'user_certification';
    protected $fillable = [
        'usersId'
    ];
}
