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

class CaseSetupController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function loadsubcases(){
        $id = Request::get('combobox1');
        $subcase = \App\Implant_sub_case::where('case_id',$id)->get();    
        return $subcase;      
    }

    public function index(){
        if(Auth::user()->usertype_id == 2 || Auth::user()->usertype_id == 4){
            $data = \App\Case_setup::query()->with('branch','agent','hospital','implant','status')
                    ->select('id','date','patient_name','branch_id','agent_id','hospital_id','implant_id','date_surgery','status_id')
                    ->orderBy('date_surgery');
        }elseif(Auth::user()->usertype_id == 1){
            $data = \App\Case_setup::query()->with('branch','agent','hospital','implant','status')
                    ->select('id','date','patient_name','branch_id','agent_id','hospital_id','implant_id','date_surgery','status_id')
                    ->where('agent_id',Auth::user()->agent_id)
                    ->orderBy('date_surgery');
        }
        

        if(Request::get('status_id') != NULL){
            $data->where('status_id',Request::get('status_id'));
        }

        if(Request::get('searchName') != NULL){
            $searchName = Request::get('searchName');
            $data->where('patient_name','LIKE',"%{$searchName}%");
        }

                
        $data = $data->simplePaginate(10);

        $data->appends(Request::all());
        $techs = \App\User::where('usertype_id',3)->orderBy('name')->get()->pluck('name','id');
        $status = \App\Case_status::pluck('name','id');
        return view('admin.case-setups.index',compact('data','techs','status'));
    }

    public function create(){
        $agents = \App\Agent::orderBy('name')->get()->pluck('name','id');
        $hospitals = \App\Hospital::orderBy('name')->get()->pluck('name','id');
        $surgeons = \App\Surgeon::orderBy('name')->get()->pluck('name','id');
        $branches = \App\Branch::orderBy('name')->get()->pluck('name','id');
        $implants = \App\Implant_case::orderBy('name')->get()->pluck('name','id');
        return view('admin.case-setups.create',compact('agents','hospitals','surgeons','branches','implants'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'agent_id'          =>      'required',
            'branch_id'         =>      'required',
            'surgeon_id'        =>      'required',
            'surgery_time'      =>      'required',
            'hospital_id'       =>      'required',
            'implant_id'        =>      'required',
            'patient_name'      =>      'required',
            'subcase_id'        =>      "required|array|min:1",
        ],
        [
            'branch_id.required'        =>  'Please select branch',
            'agent_id.required'         =>  'Please select agent',
            'surgeon_id.required'       =>  'Please select surgeon',
            'surgery_time.required'     =>  'Please Surgery Time',
            'hospital_id.required'      =>  'Please select hospital',
            'implant_id.required'       =>  'Please select implant case',
            'patient_name.required'     =>  'Patient Name Required',
            'subcase_id.required'       =>  'Please select implant subcases',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $case_setup_id = \App\Case_setup::create(Request::except('subcase_id'))->id;
        \App\Case_setup::where('id',$case_setup_id)->update([
            'status_id'     =>      1,
        ]);

        foreach(Request::get('subcase_id') as $key => $value){
            \App\Case_subcase::create([
                'case_setup_id'     =>      $case_setup_id,
                'subcase_id'        =>      $value,
                'case_id'           =>      Request::get('implant_id'),
            ]);
        }

        Alert::success('Success', 'Case Setup Created Successfully');
        return redirect()->back();
    }

    public function edit($id){
        $cs = \App\Case_setup::find($id);
        $agents = \App\Agent::orderBy('name')->get()->pluck('name','id');
        $hospitals = \App\Hospital::orderBy('name')->get()->pluck('name','id');
        $surgeons = \App\Surgeon::orderBy('name')->get()->pluck('name','id');
        $branches = \App\Branch::orderBy('name')->get()->pluck('name','id');
        $implants = \App\Implant_case::orderBy('name')->get()->pluck('name','id');
        return view('admin.case-setups.edit',compact('cs','agents','hospitals','surgeons','branches','implants'));
    }

    public function update($id){
        $cs = \App\Case_setup::find($id);
        $validator = Validator::make(Request::all(), [
            'agent_id'          =>      'required',
            'branch_id'         =>      'required',
            'surgeon_id'        =>      'required',
            'surgery_time'      =>      'required',
            'hospital_id'       =>      'required',
            //'implant_id'        =>      'required',
            'patient_name'      =>      'required',
            //'subcase_id'        =>      "required|array|min:1",
        ],
        [
            'branch_id.required'        =>  'Please select branch',
            'agent_id.required'         =>  'Please select agent',
            'surgeon_id.required'       =>  'Please select surgeon',
            'surgery_time.required'     =>  'Please Surgery Time',
            'hospital_id.required'      =>  'Please select hospital',
            //'implant_id.required'       =>  'Please select implant case',
            'patient_name.required'     =>  'Patient Name Required',
            //'subcase_id.required'       =>  'Please select implant subcases',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $cs->update(Request::except('subcase_id'));
        if(Request::has('subcase_id')){
            foreach(Request::get('subcase_id') as $key => $value){
                \App\Case_subcase::updateOrCreate([
                    'case_setup_id'     =>      $cs->id,
                    'subcase_id'        =>      $value,
                    'case_id'           =>      Request::get('implant_id'),
                ]);   
            }
        }

        if($cs->status_id > 1){
            $cs->update([
                'status_id'     =>      $cs->status_id,
            ]);
        }

        Alert::success('Success', 'Case Setup Updated Successfully');
        return redirect()->back();
    }

    public function view_loaner_form($id){
        $cs = \App\Case_setup::find($id);
        return view('admin.case-setups.view-loaner-form',compact('cs'));
    }

    public function view_loaner_form_items($case_setup_id,$lf_id){
        $lf = \App\Loaner_form::find($lf_id);
        $cs = \App\Case_setup::find($case_setup_id);
        return view('admin.case-setups.view-loaner-form-list',compact('lf','cs'));
    }

    public function post_loaner_form_items($case_setup_id,$lf_id){
        $lf = \App\Loaner_form::find($lf_id);
        $cs = \App\Case_setup::find($case_setup_id);

        $validator = Validator::make(Request::all(), [
            'qty_delivered.*'           =>      'required|numeric',
            'qty_used.*'                =>      'required|numeric',
        ],
        [
            'qty_delivered.*.required'  =>      'Please enter quantity to delivered',
            'qty_used.*.required'       =>      'Please enter quantity to used',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        foreach(Request::get('lfi_id') as $key => $value){
            \App\Case_check_list::updateOrCreate([
                'case_setup_id'     =>      $cs->id,
                'lfi_id'            =>      $value,
                'branch_id'         =>      $cs->branch_id,
                'date_delivery'     =>      $cs->date_delivery,
                'product_id'        =>      Request::get('product_id')[$key],
            ],[
                'qty_delivered'     =>      Request::get('qty_delivered')[$key],
                'qty_used'          =>      Request::get('qty_used')[$key],
            ]);
        }

        if($cs->status_id >= 2){
            $cs->update([
                'status_id'     =>      $cs->status_id,
            ]);
        }else{
            $cs->update([
                'status_id'     =>      2,
            ]);
        }
        

        Alert::success('Success', 'Case Checklist Updated Successfully');
        return redirect()->back();
    }

    public function post_assign_technician($id){
        $cs = \App\Case_setup::find($id);
        $validator = Validator::make(Request::all(), [
            'technician_id'             =>      'required',
        ],
        [
            'technician_id.required'    =>      'Please Select Technician',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        \App\Case_technician::updateOrCreate([
            'case_setup_id'     =>      $cs->id,
        ],[
            'technician_id'     =>      Request::get('technician_id'),
        ]);

        Alert::success('Success', 'Case Checklist Updated Successfully');
        return redirect()->back();
    }

    public function set_case_pullout($id){
        $cs = \App\Case_setup::find($id);
        foreach($cs->case_checklists as $ccl){
            $ccl->update([
                'isPulledout'   =>  1,
            ]);
        }

        if($cs->status_id >= 3){
            $cs->update([
                'status_id'     =>      $cs->status_id,
            ]);
        }else{
            $cs->update([
                'status_id'     =>      3,
            ]);
        }

        Alert::success('Success', 'Case Checklist Pulled Out Successfully');
        return redirect()->back();
    }

    public function post_voucher($id){
        $cs = \App\Case_setup::find($id);
        $validator = Validator::make(Request::all(), [
            'control_number'                =>      "required|unique:case_vouchers,control_number,$cs->id,id",
            'pricing_type'                  =>      'required',
        ],
        [
            'control_number.required'       =>      'Control # Required',
            'pricing_type.required'         =>      'Please Select Pricing Type',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        \App\Case_voucher::updateOrCreate([
            'case_setup_id'         =>      $cs->id,
        ],[
            'control_number'        =>      Request::get('control_number'),
            'pricing_type'          =>      Request::get('pricing_type'),
        ]);

        if($cs->status_id >= 4){
            $cs->update([
                'status_id'     =>      $cs->status_id,
            ]);
        }else{
            $cs->update([
                'status_id'     =>      4,
            ]);
        }

        Alert::success('Success', 'Case Voucher Created Successfully');
        return redirect()->back();
    }

    public function print_voucher($id){
        $voucher = \App\Case_voucher::with('case_setup','case_setup.case_checklists','case_setup.case_checklists.product')->find($id);
        $setting = \App\Setting::orderBy('id','DESC')->first();
        return View('admin.pdf.voucher',compact('voucher','setting'));
    }

    public function set_paid($id){
        $cs = \App\Case_setup::find($id);
        $cs->update([
            'status_id'     =>      5,
        ]);

        Alert::success('Success', 'Case Setup Paid Successfully');
        return redirect()->back();
    }

    public function delete_case($id){
        $cs = \App\Case_setup::find($id);
        $cs->case_subcases()->delete();
        $cs->case_checklists()->delete();
        $cs->voucher()->delete();
        $cs->technician()->delete();
        $cs->delete();
        Alert::success('Success', 'Case Setup Deleted Successfully');
        return redirect()->back();
    }

    public function delete_voucher($id){
        $cs = \App\Case_setup::find($id);
        $cs->voucher()->delete();
        $cs->update([
            'status_id'     =>      3,
        ]);
        Alert::success('Success', 'Case Voucher Deleted Successfully');
        return redirect()->back();
    }
}
