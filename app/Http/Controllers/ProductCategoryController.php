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


class ProductCategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Product_category::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Product_category::query()->select('id','name')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.product-categories.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:product_categories',
        ],
        [
            'name.required'      =>  'Category Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        \App\Product_category::create(Request::all());
        Alert::success('Success', 'Product Category Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $category = \App\Product_category::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:product_categories,name,$category->id,id",
        ],
        [
            'name.required'      =>  'Category Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update(Request::all());
        Alert::success('Success', 'Product Category Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
