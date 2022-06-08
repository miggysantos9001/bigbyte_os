@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Case Setups Module</h2>
    </header> 
    <div class="row">
        <div class="col-12 mb-2">
            @include('alert')
            <a href="{{ route('case-setups.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Create Setup</a>
            <a href="{{ route('case-setups.index') }}" class="btn btn-success btn-sm"><i class="fa fa-retweet"></i> Reset Search</a>
        </div>
        <div class="col-12">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Case Setup List</h4>
                </header>
                <div class="card-body">
                    <section class="card">
                        <div class="card-body">
                            <form class="row gx-3 gy-2 align-items-center" method="GET" action="">
                                @csrf
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        {!! Form::select('status_id',$status,null,['class'=>'form-control form-control-sm','placeholder'=>'Select Status']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm" name="searchName" placeholder="Search Patient Name">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </form>
                        </div>
                    </section>
                    <table class="table table-sm table-condensed table-no-more" style="text-transform:uppercase;font-size:12px;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Branch</th>
                                <th class="text-center">Agent</th>
                                <th class="text-center">Hospital</th>
                                <th class="text-center">Case</th>
                                <th class="text-center">Patient Name</th>
                                <th class="text-center" width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <td data-title="#" class="text-center">{{ $loop->iteration }}</td>
                                <td data-title="Name" class="text-center">{{ $d->status->name }}</td>
                                <td data-title="Name" class="text-center">{{ \Carbon\Carbon::parse($d->date_surgery)->toFormattedDateString() }}</td>
                                <td data-title="Name" class="text-center">{{ $d->branch->code }}</td>
                                <td data-title="Name" class="text-center">{{ $d->agent->code }}</td>
                                <td data-title="Name" class="text-center">{{ $d->hospital->code }}</td>
                                <td data-title="Name" class="text-center">{{ $d->implant->name }}</td>
                                <td data-title="Name" class="text-center">{{ $d->patient_name }}</td>
                                <td data-title="Action" class="text-center">
                                    @if(Auth::user()->usertype_id == 2 || Auth::user()->usertype_id == 4)
                                        @if($d->status_id != 5)
                                        <div class="btn-group flex-wrap">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a class="dropdown-item text-1" href="{{ route('case-setups.edit',$d->id) }}">Edit Entry</a>
                                                <a class="dropdown-item text-1" href="{{ route('cs.view-lf',$d->id) }}">View Loaner Form</a>
                                                <a class="dropdown-item text-1" data-bs-target="#tech{{ $d->id }}" data-bs-toggle="modal">Assign Technician</a>
                                                <a class="dropdown-item text-1" data-bs-target="#delete-case{{ $d->id }}" data-bs-toggle="modal">Delete Case Setup</a>
                                                @if($d->case_checklists->count() > 0)
                                                    @if($d->voucher != NULL)
                                                    <a class="dropdown-item text-1" data-bs-target="#voucher{{ $d->id }}" data-bs-toggle="modal">Update Voucher</a>
                                                    <a class="dropdown-item text-1" href="{{ route('cs.voucher',$d->id) }}">Print Voucher</a>
                                                    <a class="dropdown-item text-1" data-bs-target="#delete-voucher{{ $d->id }}" data-bs-toggle="modal">Delete Voucher</a>
                                                    <a class="dropdown-item text-1" href="{{ route('cs.paid',$d->id) }}">Set Paid</a>
                                                    @else
                                                    <a class="dropdown-item text-1" data-bs-target="#voucher{{ $d->id }}" data-bs-toggle="modal">Create Voucher</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                        <div class="btn-group flex-wrap">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a class="dropdown-item text-1" href="{{ route('cs.view-lf',$d->id) }}">View Loaner Form</a>
                                                @if($d->case_checklists->count() > 0)
                                                    @if($d->voucher != NULL)
                                                    <a class="dropdown-item text-1" href="{{ route('cs.voucher',$d->id) }}">Print Voucher</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @else
                                    <div class="btn-group flex-wrap">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item text-1" href="{{ route('case-setups.edit',$d->id) }}">Edit Entry</a>
                                            <a class="dropdown-item text-1" href="{{ route('cs.view-lf',$d->id) }}">View Loaner Form</a>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">NO RECORD FOUND</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {!! $data->links() !!}
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
@push('modals')
@foreach($data as $d)
<?php 
    $assignTech = \App\Case_technician::where('case_setup_id',$d->id)
        ->first();
?>
<div id="tech{{ $d->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['method'=>'POST','action'=>['CaseSetupController@post_assign_technician',$d->id]]) !!}
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Assign Case Technician</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p style="text-transform: uppercase;font-weight: bold;">Assigned Technician: {{ ($assignTech != NULL) ? $assignTech->tech->name : 'NONE' }}</p>
                        <div class="form-group">
                            {!! Form::label('Select Technician') !!}
                            {!! Form::select('technician_id',$techs,($assignTech != NULL) ? $assignTech->technician_id : null ,['class'=>'select2 form-control form-control-sm','style'=>'width:100%;','placeholder'=>'PLEASE SELECT']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Entry</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- VOUCHER -->
<div id="voucher{{ $d->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['method'=>'POST','action'=>['CaseSetupController@post_voucher',$d->id]]) !!}
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Create Voucher</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Control Number') !!}
                            {!! Form::text('control_number',($d->voucher != NULL) ? $d->voucher->control_number : null,['class'=>'form-control form-control-sm']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Select Pricing Type') !!}
                            {!! Form::select('pricing_type',['AGENT'=>'AGENT','OUTSOURCE'=>'OUTSOURCE'],($d->voucher != NULL) ? $d->voucher->pricing_type : null,['class'=>'select2 form-control form-control-sm','style'=>'width:100%;','placeholder'=>'PLEASE SELECT']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Entry</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- DELETE CASE -->
<div id="delete-case{{ $d->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Delete Case</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h3 class="text-center">Are you sure you want to delete this entry?</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('cs.delete-case',$d->id) }}" class="btn btn-primary">Delete Entry</a>
            </div>
        </div>
    </div>
</div>
<div id="delete-voucher{{ $d->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Delete Voucher</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h3 class="text-center">Are you sure you want to delete this entry?</h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('cs.delete-voucher',$d->id) }}" class="btn btn-primary">Delete Entry</a>
            </div>
        </div>
    </div>
</div>
@endforeach
@endpush