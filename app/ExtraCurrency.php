<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraCurrency extends Model
{
    public $timestamps = false;
    
    public function getName() {
        return $this->name;
    }
}
