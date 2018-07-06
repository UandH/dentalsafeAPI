<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendationTda extends Model
{
    public function tdaChild() {
        return $this->belongsTo('App\Tda');
    }

    public function teethChild() {
        return $this->belongsTo('App\Teeth');
    }

    public function recommendationChild() {
        return $this->belongsTo('App\Recommendation');
    }
    
    public function diagnosisParent() {
        return $this->hasMany('App\Diagnosis');
    }
}
