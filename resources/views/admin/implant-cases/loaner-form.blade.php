@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Implant Cases Module</h2>
    </header> 
    <div class="row">
        <div class="col-12 mb-2">
            @include('alert')
            <a href="{{ route('implant-cases.create-loaner-form',$subcase->id) }}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Create Loaner Form</a>
            <a href="{{ route('implant-cases.subcase',$subcase->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> Back to Main</a>
        </div>
        <div class="col-12">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">Loaner Form for {{ $subcase->name }}</h4>
                </header>
                <div class="card-body">
                    <section class="card">
                        <div class="card-body">
                            <form class="row gx-3 gy-2 align-items-center" method="GET" action="">
                                @csrf
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" name="searchName" placeholder="Search Implant Subcase Name">
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
                                <th class="text-center" width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <td data-title="#" class="text-center">{{ $loop->iteration }}</td>
                                <td data-title="Name" class="text-center">{{ $d->name }}</td>
                                <td data-title="Action" class="text-center">
                                    <div class="btn-group flex-wrap">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item text-1" href="{{ route('implant-cases.update-loaner-form',$d->id) }}">Edit Entry</a>
                                            <a class="dropdown-item text-1" href="{{ route('implant-cases.view-items',$d->id) }}">View Items</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">NO RECORD FOUND</td>
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
