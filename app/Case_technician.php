<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Case_technician extends Model
{
    protected $guarded = [];

    public function tech(){
        return $this->belongsTo('App\User','technician_id','id');
    }

    public function case_setup(){
        return $this->belongsTo('App\Case_setup','case_setup_id','id');
    }
}
