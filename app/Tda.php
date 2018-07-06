<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tda extends Model
{
    protected $fillable = [
        'tda',
    ];
    public function tdas() {
        return $this->belongsTo('App\RecommendationTda');
    }
}
