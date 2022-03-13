<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraCountry extends Model
{
    public $timestamps = false;
    
    public function getName() {
        return $this->nicename;
    }

    public function getCode() {
        return $this->phonecode;
    }
}
