<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class FeaturedSubscriber extends Model { 

    protected $table   = 'featured_subscriber';

    public function user() {

        return $this->hasOne(User::class, 'id', 'usersId');
        
    }

}
