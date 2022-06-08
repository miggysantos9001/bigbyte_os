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


class AgentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = \App\Agent::query()->select('id','name','code')
                ->where('name','LIKE',"%{$searchName}%")
                ->orWhere('code','LIKE',"%{$searchName}%")
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = \App\Agent::query()->select('id','name','code')
                ->where('isActive',0)
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.agents.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required',
            'code'               =>  'required|unique:agents',
        ],
        [
            'name.required'      =>  'Agent Name Required',
            'code.required'      =>  'Agent Code Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $agent_id = \App\Agent::create(Request::all())->id;
        \App\User::create([
            'name'          =>      Request::get('code'),
            'usertype_id'   =>      1,
            'password'      =>      \Hash::make(preg_replace('/\s+/', '',strtolower(Request::get('code')))),
            'agent_id'      =>      $agent_id,
        ]);
        Alert::success('Success', 'Agent Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $agent = \App\Agent::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required',
            'code'               =>  "required|unique:agents,code,$agent->id,id",
        ],
        [
            'name.required'      =>  'Agent Name Required',
            'code.required'      =>  'Agent Code Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $agent->update(Request::all());
        Alert::success('Success', 'Agent Updated Successfully');
        return redirect()->back();
    }

    public function delete($id){

    }
}
