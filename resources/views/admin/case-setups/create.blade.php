@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Case Setup Module</h2>
    </header> 
    {!! Form::open(['method' => 'POST','action'=>'CaseSetupController@store']) !!}
    <div class="row">
        <div class="col-12 mb-2">
            @include('alert')
            <a href="{{ route('case-setups.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> Back to Main</a>
        </div>
        <div class="col-8">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Create Case Setup</h4>
                </header>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('','Setup Date') !!}
                                {!! Form::date('date',\Carbon\Carbon::now()->toDateString(),['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Patient Name') !!}
                                {!! Form::text('patient_name',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Select Branch') !!}
                                {!! Form::select('branch_id',$branches,null,['class'=>'select2 form-control form-control-sm','placeholder'=>'-- Select One --','style'=>'width:100%;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Select Agent') !!}
                                {!! Form::select('agent_id',$agents,null,['class'=>'select2 form-control form-control-sm','placeholder'=>'-- Select One --','style'=>'width:100%;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Select Hospital') !!}
                                {!! Form::select('hospital_id',$hospitals,null,['class'=>'select2 form-control form-control-sm','placeholder'=>'-- Select One --','style'=>'width:100%;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Select Surgeon') !!}
                                {!! Form::select('surgeon_id',$surgeons,null,['class'=>'select2 form-control form-control-sm','placeholder'=>'-- Select One --','style'=>'width:100%;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Select Implant') !!}
                                {!! Form::select('implant_id',$implants,null,['class'=>'select2 form-control form-control-sm','placeholder'=>'-- Select One --','id'=>'combo1','style'=>'width:100%;']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Select Sub Cases') !!}
                                <select class= "select2 form-control form-control-sm" name="subcase_id[]" id="combo2" multiple="multiple" style="width:100%;">                     
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-4">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Case Setup Schedule</h4>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('','Delivery Date') !!}
                                {!! Form::date('date_delivery',\Carbon\Carbon::now()->toDateString(),['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Surgery Date') !!}
                                {!! Form::date('date_surgery',\Carbon\Carbon::now()->toDateString(),['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('','Surgery Time') !!}
                                {!! Form::time('surgery_time',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save Entry</button>
                </div>
            </section>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection
@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var case_id = $('#combo1').val();

    $.ajax({    //create an ajax request to load_page.php
        type: 'GET',
        url: "{{ action('CaseSetupController@loadsubcases') }}",//php file url diri     
        dataType: "json",    
        data: { combobox1 : case_id },
        success: function(response){
            //$("#combo2").append('<option value="">PLEASE SELECT</option>');
            $.each(response,function(index,value){
                $("#combo2").append('<option value="'+value.id+'">'+value.name+'</option>');
          
           });            
        }
    });

    $('#combo1').change(function() {
        var combobox1 = $(this).val(); 
       $("#combo2").html("");
        $.ajax({    //create an ajax request to load_page.php
            type: 'GET',
            url: "{{ action('CaseSetupController@loadsubcases') }}",//php file url diri     
            dataType: "json",    
            data: { combobox1 : combobox1 },
            success: function(response){
                //$("#combo2").append('<option value="">PLEASE SELECT</option>')
                $.each(response,function(index,value){
                    $("#combo2").append('<option value="'+value.id+'">'+value.name+'</option>');
              
               });
            }
        });
    });

</script>
@endpush