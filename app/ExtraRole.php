<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraRole extends Model
{
    public function getName() {
        return $this->name;   
    }

    public function getPrefix() {
        return $this->prefix;   
    }
}
