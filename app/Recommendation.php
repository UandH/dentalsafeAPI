<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'recommendation',
    ];
    public function recommendations() {
        return $this->belongsTo('App\RecommendationTda');
    }
}
