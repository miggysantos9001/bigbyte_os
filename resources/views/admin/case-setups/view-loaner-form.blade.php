@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Case Setups Module</h2>
    </header> 
    <div class="row">
        <div class="col-12 mb-2">
            @include('alert')
            <a href="{{ route('case-setups.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> Back to Case Setups</a>
            @if($cs->status_id <= 2)
            <a href="{{ route('cs.pullout',$cs->id) }}" class="btn btn-success btn-sm"><i class="fa fa-cart-arrow-down"></i> Pullout Items</a>
            @endif
        </div>
        <div class="col-12">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">View Loaner Forms</h4>
                </header>
                <div class="card-body">
                    @forelse($cs->case_subcases as $row)
                    <p class="page-title" style="text-transform:uppercase;">{{ $row->subcase->name }}</p>
                    <table class="table table-sm table-condensed table-no-more" style="text-transform:uppercase;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Loaner Form</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($row->loaner_forms as $rlf)
                            <tr>
                                <td class="text-center" data-title="#">{{ $loop->iteration }}</td>
                                <td class="text-center" data-title="Loaner Form">{{ $rlf->name }}</td>
                                <td class="text-center" data-title="Status">{{ ($cs->status_id == 3) ? 'CLOSED' : 'OPEN' }}</td>
                                <td class="text-center" data-title="Action">
                                    <div class="btn-group flex-wrap">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item text-1" href="{{ url('case-setup/view-loaner-form-items/'.$cs->id.'/'.$rlf->id) }}">View Items</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">NO RECORDS FOUND</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @empty
                    <h4 class="page-title text-center">NO RECORDS FOUND</h4>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</section>
@endsection