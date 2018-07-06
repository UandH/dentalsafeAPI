<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $fillable = [
        'name'
    ];
    public function communesParent() {
        return $this->belongsTo('App\Province');
    }
    public function communesChild() {
        return $this->hasMany('App\MedicalEstablishment');
    }
}
