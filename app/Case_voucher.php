<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Case_voucher extends Model
{
    protected $guarded = [];

    public function case_setup(){
        return $this->belongsTo('App\Case_setup','case_setup_id','id');
    }
}
