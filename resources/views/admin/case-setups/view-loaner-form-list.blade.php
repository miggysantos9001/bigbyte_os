@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Case Setups Module</h2>
    </header> 
    <div class="row">
        <div class="col-12 mb-2">
            @include('alert')
            <a href="{{ route('cs.view-lf',$cs->id,$lf->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> Back to Loaner Forms</a>
        </div>
        <div class="col-12">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h4 class="card-title">View Loaner Form List of {{ $lf->name }}</h4>
                </header>
                {!! Form::open(['method'=>'POST','action'=>['CaseSetupController@post_loaner_form_items',$cs->id,$lf->id]]) !!}
                <div class="card-body">
                    <table class="table table-sm table-condensed table-no-more" style="text-transform:uppercase;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Product Catalog</th>
                                <th class="text-center">Product Description</th>
                                <th class="text-center">Quantity Delivered</th>
                                <th class="text-center">Quantity Used</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lf->lf_list as $row)
                            <?php 
                                $checkCCL = \App\Case_check_list::where('case_setup_id',$cs->id)
                                    ->where('lfi_id',$row->id)
                                    ->where('product_id',$row->product_id)
                                    ->first();
                            ?>
                            <tr>
                                <td class="text-center" data-title="#">{{ $loop->iteration }}</td>
                                <td class="text-center" data-title="Product Catalog">{{ $row->product->catalog_no }}</td>
                                <td class="text-center" data-title="Product Description">{{ $row->product->description }}</td>
                                <td class="text-center" data-title="Quantity Delivered">
                                    {!! Form::text('qty_delivered[]',($checkCCL != NULL) ? $checkCCL->qty_delivered : '0',['class'=>'','style'=>'width:50px;text-align:center;']) !!}
                                </td>
                                <td class="text-center" data-title="Quantity Used">
                                    {!! Form::text('qty_used[]',($checkCCL != NULL) ? $checkCCL->qty_used : '0',['class'=>'','style'=>'width:50px;text-align:center;']) !!}
                                    {!! Form::hidden('case_setup_id[]',$cs->id,['class'=>'','style'=>'width:50px;text-align:center;']) !!}
                                    {!! Form::hidden('lfi_id[]',$row->id,['class'=>'','style'=>'width:50px;text-align:center;']) !!}
                                    {!! Form::hidden('product_id[]',$row->product_id,['class'=>'','style'=>'width:50px;text-align:center;']) !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save Entry</button>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
    </div>
</section>
@endsection