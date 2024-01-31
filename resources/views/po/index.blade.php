@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
        <div class="card">
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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Purchase Order List</b> </span>
                <a class="btn btn-sm btn-primary" href="{{route('po.create')}}">New Purchase Order Creation</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>PO Number</th>
                                    <th>PO Date</th>
                                    <th>Code</th>
                                    <th>Supplier Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($po_datas as $po_data)
                                <tr>

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$po_data->ponumber}}</td>
                                    <td>{{date('d-m-Y', strtotime($po_data->podate))}}</td>
                                    <td>{{$po_data->supplier->supplier_code}}</td>
                                    <td>{{$po_data->supplier->name}}</td>
                                    <td>@if ($po_data->status==1)
                                        <span class="btn btn-sm text-white btn-danger">PENDING</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-success">CLOSE</span>
                                    @endif</td>
                                    <td>
                                        {{-- <a href="{{route('po.edit',$po_data->id)}}" class="btn btn-sm btn-primary  me-md-2 text-white">Correction Request</a> --}}
                                        <a href="{{route('po.correction',$po_data->id)}}"  data-toggle="tooltip"  data-id="{{$po_data->id}}" data-original-title="Edit" class="edit btn btn-info mx-2 btn-sm text-white">Correction Request</a>
                                        <a href="{{route('po.print',$po_data->id)}}"  data-toggle="tooltip"  data-id="{{$po_data->id}}" data-original-title="Edit" class="edit btn btn-info mx-2 btn-sm text-white">Print</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" align="center">No Records Found!</td>
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
