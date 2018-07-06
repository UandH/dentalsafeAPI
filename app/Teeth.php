<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teeth extends Model
{
    protected $fillable = [
        'type',
    ];
    public function teeths() {
        return $this->belongsTo('App\RecommendationTda');
    }
}
