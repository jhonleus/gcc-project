<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = ['usersId'];

    public function requirements()
    {
        return $this->hasOne(User::class, 'id', 'usersId');
    }
}
