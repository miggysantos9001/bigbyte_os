<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Case_subcase extends Model
{
    protected $guarded = [];

    public function implant(){
        return $this->belongsTo('App\Implant_case','case_id','id');
    }

    public function case_setup(){
        return $this->belongsTo('App\Case_setup','case_setup_id','id');
    }

    public function subcase(){
        return $this->belongsTo('App\Implant_sub_case','subcase_id','id');
    }

    public function loaner_forms(){
        return $this->hasMany('App\Loaner_form','subcase_id','subcase_id');
    }
}
