<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Implant_sub_case extends Model
{
    protected $guarded = [];

    public function implant(){
        return $this->belongsTo('App\Implant_case','case_id','id');
    }

    public function loaner_forms(){
        return $this->hasMany('App\Loaner_form','subcase_id','id');
    }
}
