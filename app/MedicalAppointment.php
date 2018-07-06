<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalAppointment extends Model
{
    protected $fillable = [
        'date'
    ];

    public function medicalappointments() {
        return $this->belongsTo('App\Diagnosis');
    }
}
