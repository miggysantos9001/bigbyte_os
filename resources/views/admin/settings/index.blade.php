@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Settings Module</h2>
    </header> 
    {!! Form::open(['method' => 'POST','action'=>'SettingController@store','files' => true]) !!}
    <div class="row">
        <div class="col-12">
            @include('alert')
        </div>
        <div class="col-8">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Create Setting</h4>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('Company Name') !!}
                                {!! Form::text('company_name',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Company Address') !!}
                                {!! Form::text('company_address',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Company Contact #') !!}
                                {!! Form::text('company_contact',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Company Logo') !!}
                                {!! Form::file('company_logo',['class'=>'form-control form-control-sm']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save Entry</button>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-success btn-sm"><i class="fa fa-home"></i> Back to Dashboard</a>
                </div>
            </section>
        </div>
        <div class="col-4">
            <?php 
                $setting = \App\Setting::orderBy('id','DESC')->first();
                if($setting != NULL){
                    $company_name = $setting->company_name;
                    $company_address = $setting->company_address;
                    $company_mobile = $setting->company_mobile;
                }else{
                    $company_name = "";
                    $company_address = "";
                    $company_mobile = "";
                }
            ?>
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">System Settings</h4>
                </header>
                <div class="card-body">
                    <div class="row">
                        <h4>Company Name: <strong>{{ $company_name }}</strong></h4>
                        <h4>Company Address: <strong>{{ $company_address }}</strong></h4>
                        <h4>Company Contact #: <strong>{{ $company_mobile }}</strong></h4>
                        @if($setting != NULL)
                        <h4>Company Logo:</h4>
                        <img src="{{ asset('public/photo/'.$setting->company_logo) }}" alt="" style="padding-bottom: 10px;">
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection