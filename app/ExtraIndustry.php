<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraIndustry extends Model
{
    public $timestamps = false;
    
    public function getName() {
        return $this->name;
    }
}
