<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = [
        'incidentDate', 'confirmed'
    ];

    public function users() {
        return $this->belongsTo('App\Users');
    }

    public function diagnoses() {
        return $this->belongsTo('App\Recommendation');
    }

    public function medicalappointments() {
        return $this->hasMany('App\MedicalAppointment');
    }
    
}
