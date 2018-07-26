<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name', 'region_number',
    ];

    public function regions() {
        return $this->hasMany('App\Province');
    }
}
