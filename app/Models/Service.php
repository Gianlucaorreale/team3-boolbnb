<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function apartment() {
        return $this->belongsToMany('App\Models\Apartment');
    }

}
