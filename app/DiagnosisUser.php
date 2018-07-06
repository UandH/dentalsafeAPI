<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisUser extends Model
{
    public function diagnosis() {
        return $this->belongsTo('App\Diagnosis');
    }

    public function users() {
        return $this->belongsTo('App\Users');
    }
}
