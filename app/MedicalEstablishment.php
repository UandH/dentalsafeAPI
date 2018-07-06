<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalEstablishment extends Model
{
    protected $fillable = [
        'type_service', 'name', 'address', 'coordinates'
    ];
    public function medicalestablishments() {
        return $this->hasMany('App\Commune');
    }
}
