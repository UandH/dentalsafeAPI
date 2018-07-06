<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name',
    ];

    public function provincesParent() {
        return $this->belongsTo('App\Region');
    }
    public function provincesChild() {
        return $this->hasMany('App\Commune');
    }
}
