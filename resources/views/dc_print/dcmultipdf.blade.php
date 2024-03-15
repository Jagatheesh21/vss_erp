@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
        <div class="card">
            <div class="col-12">
                @if(Session::has('success'))
                <div class="alert alert-success mt-4">
                {{ Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger mt-4">
                {{ Session::get('error')}}
                </div>
            @endif
            @if (session()->has('message'))
                <div class="alert alert-danger mt-4">
                {{ session()->get('message')}}
                </div>
            @endif
            <form action="{{route('dcmultipdf')}}" method="post">
                @csrf
                @method('POST')
                <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Multi Delivery challan List</b> </span>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="table">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>DC Number</th>
                                            <th>DC Date</th>
                                            <th>Part No</th>
                                            <th>Quantity</th>
                                            <th>UOM</th>
                                            <th>Unit Rate</th>
                                            <th>Total Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_logic">
                                        @foreach ($dc_transactionDatas as $dc_transactionData)
                                            <tr>
                                                <td>{{$dc_transactionData->dc_no}}</td>
                                                <td>{{$dc_transactionData->issue_date}}</td>
                                                <td>{{$dc_transactionData->part_no}}</td>
                                                <td>{{$dc_transactionData->issue_qty}}</td>
                                                <td>{{$dc_transactionData->uom}}</td>
                                                <td>{{$dc_transactionData->unit_rate}}</td>
                                                <td>{{$dc_transactionData->total_rate}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

