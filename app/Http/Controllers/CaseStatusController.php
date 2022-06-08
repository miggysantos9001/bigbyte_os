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

class CaseStatusController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Case_status::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Case_status::query()->select('id','name')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.case-statuses.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:case_statuses',
        ],
        [
            'name.required'      =>  'Status Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Case_status::create(Request::all());
        Alert::success('Success', 'Case Status Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $status = \App\Case_status::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:case_statuses,name,$status->id,id",
        ],
        [
            'name.required'      =>  'Status Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $status->update(Request::all());
        Alert::success('Success', 'Case Status Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
