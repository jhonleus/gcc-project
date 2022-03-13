<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHobby extends Model
{
    public $timestamps = false;

    public function hobby()
    {
        return $this->hasOne(ExtraHobby::class, 'id', 'hobbyId');
    }

}
