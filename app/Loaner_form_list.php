<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaner_form_list extends Model
{
    protected $guarded = [];

    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }

    public function loanerform(){
        return $this->belongsTo('App\Loaner_form','loaner_form_id','id');
    }
}
