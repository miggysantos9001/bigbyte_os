@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Implant Cases Module</h2>
    </header> 
    <div class="row">
        <div class="col-12 mb-2">
            @include('alert')
            <a href="{{ route('implant-cases.loaner-form',$lf->subcase_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> Back to Loaner Forms</a>
        </div>
        <div class="col-12">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Loaner Form Items for {{ $lf->name }}</h4>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-condensed" id="myTable" style="text-transform:uppercase;">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Catalog #</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center" width="80">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lf->lf_list as $lfl)
                                    <tr>
                                        <td data-title="#" class="text-center">{{ $loop->iteration }}</td>
                                        <td data-title="Catalog #" class="text-center">{{ $lfl->product->catalog_no }}</td>
                                        <td data-title="Description" class="text-center">{{ $lfl->product->description }}</td>
                                        <td data-title="Quantity" class="text-center">{{ $lfl->qty }}</td>
                                        <td data-title="Action" class="text-center">
                                            <div class="btn-group flex-wrap">
                                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    <a class="dropdown-item text-1" data-bs-target="#delete{{ $lfl->id }}" data-bs-toggle="modal">Delete Entry</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
@push('modals')
@foreach($lf->lf_list as $lfl)
<div id="delete{{ $lfl->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Delete Entry {{ $lfl->product->description }}</h5>
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
                <a href="{{ route('implant-cases.delete-item',$lfl->id) }}" class="btn btn-primary">Delete Entry</a>
            </div>
        </div>
    </div>
</div>
@endforeach
@endpush