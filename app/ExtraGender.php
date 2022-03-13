<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraGender extends Model
{
    public function getName() {
        return $this->name;
    }
}
