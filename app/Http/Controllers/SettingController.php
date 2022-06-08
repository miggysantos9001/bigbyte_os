<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Alert;
use DB;
use Auth;

class SettingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.settings.index');
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'company_name'                  =>  'required',
            'company_address'               =>  'required',
            'company_contact'               =>  'required',
            'company_logo'                  =>  'required',
        ],
        [
            'company_name.required'         =>  'Company Name Required',
            'company_address.required'      =>  'Company Address Required',
            'company_contact.required'      =>  'Company Contact # Required',
            'company_logo.required'         =>  'Company Logo Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = Request::file('company_logo');

        if($file != NULL){
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(50).'.'.$extension;
            $file->move(public_path().'/photo',$fileName);
        }

        \App\Setting::updateOrCreate([
            'company_name'          =>      Request::get('company_name'),
            'company_address'       =>      Request::get('company_address'),
            'company_mobile'        =>      Request::get('company_contact'),
            'company_logo'          =>      $fileName,
        ]);

        Alert::success('Success', 'Settings Created Successfully');
        return redirect()->back();
    }
}
