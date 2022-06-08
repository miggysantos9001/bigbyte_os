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

class ImplantCaseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Implant_case::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Implant_case::query()->select('id','name')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.implant-cases.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'      =>      'required|unique:implant_cases',
        ],
        [
            'name.required'     =>  'Implant Case Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Implant_case::create(Request::all());
        Alert::success('Success', 'Implant Case Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $implant = \App\Implant_case::find($id);
        $validator = Validator::make(Request::all(), [
            'name'      =>      "required|unique:implant_cases,name,$implant->id,id",
        ],
        [
            'name.required'     =>  'Implant Case Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $implant->update(Request::all());
        Alert::success('Success', 'Implant Case Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }

    public function subcase_index($id){
        $implant = \App\Implant_case::find($id);
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Implant_sub_case::query()->select('id','name','case_id')
                ->where('case_id',$implant->id)
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Implant_sub_case::query()->select('id','name','case_id')
                ->where('case_id',$implant->id)
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.implant-cases.subcase',compact('data','implant'));
    }

    public function subcase_store($id){
        $implant = \App\Implant_case::find($id);
        $validator = Validator::make(Request::all(), [
            'name'              =>      'required|unique:implant_sub_cases',
        ],
        [
            'name.required'     =>      'Implant Sub Case Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Implant_sub_case::create([
            'case_id'       =>      $implant->id,
            'name'          =>      Request::get('name'),
        ]);

        Alert::success('Success', 'Implant Sub Case Created Successfully');
        return redirect()->back();
    }

    public function subcase_update($id){
        $subcase = \App\Implant_sub_case::find($id);
        $validator = Validator::make(Request::all(), [
            'name'              =>      "required|unique:implant_sub_cases,name,$subcase->id,id",
        ],
        [
            'name.required'     =>      'Implant Sub Case Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subcase->update(Request::all());
        Alert::success('Success', 'Implant Sub Case Updated Successfully');
        return redirect()->back();
    }

    public function loanerform_index($id){
        $subcase = \App\Implant_sub_case::find($id);
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Loaner_form::query()->select('id','name','subcase_id')
                ->where('subcase_id',$subcase->id)
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Loaner_form::query()->select('id','name','subcase_id')
                ->where('subcase_id',$subcase->id)
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.implant-cases.loaner-form',compact('data','subcase'));
    }

    public function loanerform_create($id){
        $subcase = \App\Implant_sub_case::find($id);
        $categories = \App\Product_category::orderBy('name')->get()->pluck('name','id');
        return view('admin.implant-cases.create-loaner-form',compact('subcase','categories'));
    }

    public function loanerform_store($id){
        $subcase = \App\Implant_sub_case::find($id);
        $validator = Validator::make(Request::all(), [
            'name'                  =>      'required',
            'product_id'            =>      "required|array|min:1",
        ],
        [
            'name.required'         =>  'Loaner Form Name Required',
            'product_id.required'   =>  'Please Check At Least One Product',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $lf = \App\Loaner_form::create([
            'subcase_id'    =>  $subcase->id,
            'name'          =>  Request::get('name'),
        ])->id;

        foreach(Request::get('product_id') as $key => $value){
            $lfi = [
                'loaner_form_id'    =>      $lf,
                'product_id'        =>      $value,
                'qty'               =>      Request::get('qty')[$key],
            ];

            \App\Loaner_form_list::create($lfi);
        }

        Alert::success('Success', 'Loaner Form Created Successfully');
        return redirect()->back();

    }

    public function loanerform_edit($id){
        $lf = \App\Loaner_form::find($id);
        $categories = \App\Product_category::orderBy('name')->get()->pluck('name','id');
        return view('admin.implant-cases.edit-loaner-form',compact('lf','categories'));
    }

    public function loanerform_update($id){
        $lf = \App\Loaner_form::find($id);
        $validator = Validator::make(Request::all(), [
            'name'                  =>      'required',
            'product_id'            =>      "required|array|min:1",
        ],
        [
            'name.required'         =>  'Loaner Form Name Required',
            'product_id.required'   =>  'Please Check At Least One Product',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $lf->update([
            'name'          =>  Request::get('name'),
        ]);

        foreach(Request::get('product_id') as $key => $value){
            \App\Loaner_form_list::updateOrCreate([
                'loaner_form_id'    =>      $lf->id,
                'product_id'        =>      $value,
            ],[
                'qty'               =>      Request::get('qty')[$key],
            ]);
        }

        Alert::success('Success', 'Loaner Form Updated Successfully');
        return redirect()->back();
    }

    public function loanerform_view_items($id){
        $lf = \App\Loaner_form::find($id);
        return view('admin.implant-cases.view-loaner-form-item',compact('lf'));
    }

    public function loanerform_delete_item($id){
        $lfi = \App\Loaner_form_list::find($id);
        $lfi->delete();
        Alert::success('Success', 'Loaner Form Item Deleted Successfully');
        return redirect()->back();
    }
}
