<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceBlog extends Model
{
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'usersId');
    }
}
