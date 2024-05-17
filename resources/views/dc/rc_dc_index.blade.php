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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Raw Material Delivery challan List</b> </span>
                <a class="btn btn-sm btn-primary text-white" href="{{route('rmdc.create')}}">New RM DC</a>
                <a class="btn btn-sm btn-info text-white" href="{{route('dcprint.index')}}">Multi DC Print</a>
                <a class="btn btn-sm btn-primary text-white" href="{{route('delivery_challan.index')}}">DC List</a>
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
                                    <th>RM Desc</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Unit Rate</th>
                                    <th>Total Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rmdcDatas as $dcData)
                                <tr>

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$dcData->dc_details->rcmaster->rc_id}}</td>
                                    <td>{{date('d-m-Y', strtotime($dcData->dc_details->issue_date))}}</td>
                                    <td>{{$dcData->dc_details->dcmaster->supplier->supplier_code}}</td>
                                    <td>{{$dcData->dc_details->dcmaster->supplier->name}}</td>
                                    <td>{{$dcData->rm_details->name}}</td>
                                    <td>{{$dcData->dc_details->issue_qty}}</td>
                                    <td>{{$dcData->dc_details->uom->name}}</td>
                                    <td>{{$dcData->dc_details->unit_rate}}</td>
                                    <td>{{$dcData->dc_details->basic_rate}}</td>
                                    <td>@if ($dcData->dc_details->status==0)
                                        <span class="btn btn-sm text-white btn-danger">OPEN</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-success">CLOSE</span>
                                    @endif</td>

                                    <td>

                                        {{-- <a href="#" class="edit btn btn-info mx-2 btn-sm text-white">Correction Request</a> --}}
                                        {{-- <a href="{{route('po.print',$dcData->id)}}"  data-toggle="tooltip"  data-id="{{$dcData->id}}" data-original-title="Edit" class="edit btn btn-info mx-2 btn-sm text-white">Print</a> --}}
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
