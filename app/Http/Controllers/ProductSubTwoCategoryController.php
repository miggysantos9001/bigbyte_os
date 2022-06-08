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

class ProductSubTwoCategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Product_sub_two_category::query()->with('subone')->select('id','name','subone_id')
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Product_sub_two_category::query()->with('subone')->select('id','name','subone_id')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        $categories = \App\Product_sub_category::orderBy('name')->get()->pluck('name','id');
        return view('admin.product-sub-two-categories.index',compact('data','categories'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'              =>  'required|unique:product_sub_two_categories',
            'subone_id'         =>  'required',    
        ],
        [
            'name.required'             =>  'Sub Two Category Name Required',
            'subone_id.required'        =>  'Please Select Sub One Category',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Product_sub_two_category::create(Request::all());
        Alert::success('Success', 'Product Sub Two Category Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $subtwocategory = \App\Product_sub_two_category::find($id);
        $validator = Validator::make(Request::all(), [
            'name'                  =>  "required|unique:product_sub_categories,name,$subtwocategory->id,id",
            'subone_id'             =>  'required',    
        ],
        [
            'name.required'             =>  'Sub Two Category Name Required',
            'subone_id.required'        =>  'Please Select Sub One Category',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subtwocategory->update(Request::all());
        Alert::success('Success', 'Product Sub Two Category Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
