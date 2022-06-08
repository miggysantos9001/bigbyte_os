<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use DB;
use Auth;

class SurgeonController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Surgeon::query()->select('id','name','branch_id')
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Surgeon::query()->select('id','name','branch_id')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        $branches = \App\Branch::orderBy('name')->get()->pluck('name','id');
        return view('admin.surgeons.index',compact('data','branches'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'              =>  'required|unique:surgeons',
            'branch_id'         =>  'required',    
        ],
        [
            'name.required'         =>  'Surgeon Name Required',
            'branch_id.required'    =>  'Please Select Branch',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Surgeon::create(Request::all());
        Alert::success('Success', 'Surgeon Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $surgeon = \App\Surgeon::find($id);
        $validator = Validator::make(Request::all(), [
            'name'              =>  "required|unique:surgeons,name,$surgeon->id,id",
            'branch_id'         =>  'required',    
        ],
        [
            'name.required'         =>  'Surgeon Name Required',
            'branch_id.required'    =>  'Please Select Branch',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $surgeon->update(Request::all());
        Alert::success('Success', 'Surgeon Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
