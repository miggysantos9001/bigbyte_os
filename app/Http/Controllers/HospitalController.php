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

class HospitalController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Hospital::query()->select('id','name','code','address')
                ->where('name','LIKE',"%{$searchName}%")
                ->orWhere('code','LIKE',"%{$searchName}%")
                ->orWhere('address','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Hospital::query()->select('id','name','code','address')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.hospitals.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'      =>      'required|unique:hospitals',
            'code'      =>      'required',
            'address'   =>      'required',
        ],
        [
            'name.required'     =>  'Hospital Name Required',
            'code.required'     =>  'Hospital Code Required',
            'address.required'  =>  'Hospital Address Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Hospital::create(Request::all());
        Alert::success('Success', 'Hospital Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $hospital = \App\Hospital::find($id);
        $validator = Validator::make(Request::all(), [
            'name'      =>  "required|unique:hospitals,name,$hospital->id,id",
            'code'      =>      'required',
            'address'   =>      'required',
        ],
        [
            'name.required'     =>  'Hospital Name Required',
            'code.required'     =>  'Hospital Code Required',
            'address.required'  =>  'Hospital Address Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $hospital->update(Request::all());
        Alert::success('Success', 'Hospital Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
