<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraSpecialization extends Model
{
    public $timestamps = false;

     public function getName() {
        return $this->name;
    }
}
