<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraReligion extends Model
{
    public $timestamps = false;
    
    public function getName() {
        return $this->name;   
    }
}
