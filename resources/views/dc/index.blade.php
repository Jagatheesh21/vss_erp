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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Delivery challan List</b> </span>
                <a class="btn btn-sm btn-primary text-white" href="{{route('delivery_challan.create')}}">New</a>
                <a class="btn btn-sm btn-info text-white" href="#">Multi DC Print</a>
                <a class="btn btn-sm btn-primary text-white" href="#">RM DC</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>DC Number</th>
                                    <th>DC Date</th>
                                    <th>Code</th>
                                    <th>Supplier Name</th>
                                    <th>Part No</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Unit Rate</th>
                                    <th>Total Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dcDatas as $dcData)
                                <tr>

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$dcData->rcmaster->rc_id}}</td>
                                    <td>{{date('d-m-Y', strtotime($dcData->issue_date))}}</td>
                                    <td>{{$dcData->dcmaster->supplier->supplier_code}}</td>
                                    <td>{{$dcData->dcmaster->supplier->name}}</td>
                                    <td>{{$dcData->dcmaster->invoicepart->part_no}}</td>
                                    <td>{{$dcData->issue_qty}}</td>
                                    <td>{{$dcData->uom->name}}</td>
                                    <td>{{$dcData->unit_rate}}</td>
                                    <td>{{$dcData->basic_rate}}</td>
                                    <td>@if ($dcData->status==0)
                                        <span class="btn btn-sm text-white btn-danger">OPEN</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-success">CLOSE</span>
                                    @endif</td>

                                    <td>

                                        {{-- <a href="#" class="edit btn btn-info mx-2 btn-sm text-white">Correction Request</a> --}}
                                        <a href="{{route('po.print',$dcData->id)}}"  data-toggle="tooltip"  data-id="{{$dcData->id}}" data-original-title="Edit" class="edit btn btn-info mx-2 btn-sm text-white">Print</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="15" align="center">No Records Found!</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
