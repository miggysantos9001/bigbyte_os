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

class ProductSubOneCategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Product_sub_category::query()->with('category')->select('id','name','category_id')
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Product_sub_category::query()->with('category')->select('id','name','category_id')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        $categories = \App\Product_category::orderBy('name')->get()->pluck('name','id');
        return view('admin.product-sub-one-categories.index',compact('data','categories'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'              =>  'required|unique:product_sub_categories',
            'category_id'       =>  'required',    
        ],
        [
            'name.required'             =>  'Sub One Category Name Required',
            'category_id.required'      =>  'Please Select Category',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Product_sub_category::create(Request::all());
        Alert::success('Success', 'Product Sub One Category Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $subcategory = \App\Product_sub_category::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:product_sub_categories,name,$subcategory->id,id",
            'category_id'       =>  'required',    
        ],
        [
            'name.required'             =>  'Sub One Category Name Required',
            'category_id.required'      =>  'Please Select Category',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subcategory->update(Request::all());
        Alert::success('Success', 'Product Sub One Category Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
