<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Case_setup extends Model
{
    protected $guarded = [];

    public function implant(){
        return $this->belongsTo('App\Implant_case','implant_id','id');
    }

    public function agent(){
        return $this->belongsTo('App\Agent','agent_id','id');
    }

    public function hospital(){
        return $this->belongsTo('App\Hospital','hospital_id','id');
    }

    public function surgeon(){
        return $this->belongsTo('App\Surgeon','surgeon_id','id');
    }

    public function status(){
        return $this->belongsTo('App\Case_status','status_id','id');
    }

    public function branch(){
        return $this->belongsTo('App\Branch','branch_id','id');
    }

    public function case_subcases(){
        return $this->hasMany('App\Case_subcase','case_setup_id','id');
    }

    public function case_checklists(){
        return $this->hasMany('App\Case_check_list','case_setup_id','id');
    }

    public function technician(){
        return $this->hasOne('App\Case_technician','case_setup_id','id');
    }

    public function voucher(){
        return $this->hasOne('App\Case_voucher','case_setup_id','id');
    }

}
