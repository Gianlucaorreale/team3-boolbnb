<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['descriptive_title', 'num_rooms', 'num_bathroom', 'num_bed', 'visibility', 'address', 'latitude', 'longitude', 'image'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function services() {
        return $this->belongsToMany('App\Models\Service');
    }

    public function sponsors() {
        return $this->belongsToMany('App\Models\Sponsor');
    }

    public function messages() {
        return $this->hasMany('App\Models\Message');
    }

    public function views() {
        return $this->hasMany('App\Models\View');
    }


}
