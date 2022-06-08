<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Implant_case extends Model
{
    protected $guarded = [];

    public function subcases(){
        return $this->hasMany('App\Implant_sub_case','case_id','id');
    }
}
