<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalEstablishment extends Model
{
    protected $fillable = [
        'name', 'address', 'lat', 'lng', 'schedule',
    ];
    public function medicalestablishments() {
        return $this->hasMany('App\Commune');
    }
}
