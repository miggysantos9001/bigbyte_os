<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaner_form extends Model
{
    protected $guarded = [];

    public function subcase(){
        return $this->belongsTo('App\Implant_sub_case','subcase_id','id');
    }

    public function lf_list(){
        return $this->hasMany('App\Loaner_form_list','loaner_form_id','id');
    }
}
