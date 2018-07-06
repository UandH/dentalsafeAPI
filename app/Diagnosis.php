<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = [
        'incidentDate', 'datesCount'
    ];

    public function diagnosisUsers() {
        return $this->hasMany('App\DiagnosisUser');
    }

    public function diagnoses() {
        return $this->belongsTo('App\RecommendationTda');
    }

    public function medicalappointments() {
        return $this->hasMany('App\MedicalAppointment');
    }
    
}
