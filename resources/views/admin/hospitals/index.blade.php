@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Hospitals Module</h2>
    </header> 
    <div class="row">
        <div class="col-12">
            @include('alert')
        </div>
        <div class="col-4">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Create Hospital</h4>
                </header>
                {!! Form::open(['method' => 'POST','action'=>'HospitalController@store']) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('Hospital Name') !!}
                                {!! Form::text('name',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Hospital Code') !!}
                                {!! Form::text('code',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Hospital Address') !!}
                                {!! Form::text('address',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save Entry</button>
                    <a href="{{ route('hospitals.index') }}" class="btn btn-success btn-sm"><i class="fa fa-retweet"></i> Reset Search</a>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
        <div class="col-8">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Hospital List</h4>
                </header>
                <div class="card-body">
                    <section class="card">
                        <div class="card-body">
                            <form class="row gx-3 gy-2 align-items-center" method="GET" action="">
                                @csrf
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" name="searchName" placeholder="Search Hospital Entry">
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
                                <th class="text-center">Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Address</th>
                                <th class="text-center" width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <td data-title="#" class="text-center">{{ $loop->iteration }}</td>
                                <td data-title="Name" class="text-center">{{ $d->name }}</td>
                                <td data-title="Code" class="text-center">{{ $d->code }}</td>
                                <td data-title="Code" class="text-center">{{ $d->address }}</td>
                                <td data-title="Action" class="text-center">
                                    <div class="btn-group flex-wrap">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item text-1" data-bs-target="#edit{{ $d->id }}" data-bs-toggle="modal">Edit Entry</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">NO RECORD FOUND</td>
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
<div id="edit{{ $d->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['method'=>'PATCH','action'=>['HospitalController@update',$d->id]]) !!}
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Update Hospital Entry {{ $d->name }}</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Hospital Name') !!}
                            {!! Form::text('name',$d->name,['class'=>'form-control form-control-sm']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Hospital Code') !!}
                            {!! Form::text('code',$d->code,['class'=>'form-control form-control-sm']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Hospital Address') !!}
                            {!! Form::text('address',$d->address,['class'=>'form-control form-control-sm']) !!}
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
@endforeach
@endpush