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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Invoice Correction List</b> </span>
                <a class="btn btn-sm btn-info text-white" href="{{route('invoicedetails.index')}}">Invoice List</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Qty</th>
                                    <th>Correction Reason</th>
                                    <th>Request By</th>
                                    <th>Request Date</th>
                                    <th>Approved By</th>
                                    <th>Approved Date</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($correctionMasterDatas as $correctionMasterData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$correctionMasterData->invoicedetails->rcmaster->rc_id}}</td>
                                    <td>{{date('d-m-Y', strtotime($correctionMasterData->invoicedetails->invoice_date))}}</td>
                                    <td>{{($correctionMasterData->qty)}}</td>
                                    <td>{{($correctionMasterData->request_reason)}}</td>
                                    <td>{{($correctionMasterData->preparedusers->name)}}</td>
                                    <td>{{($correctionMasterData->correction_request_date)}}</td>
                                    <td>@if ($correctionMasterData->approved_by!=NULL)
                                        {{($correctionMasterData->approvedusers->name)}}
                                        @else
                                    @endif</td>
                                    <td>{{($correctionMasterData->approved_date)}}</td>
                                    <td>@if ($correctionMasterData->status==2)
                                        <span class="btn btn-sm text-white btn-danger">REJECTED</span>
                                        @elseif ($correctionMasterData->status==1)
                                        <span class="btn btn-sm text-white btn-success">APPROVED</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-info">PENDING</span>
                                    @endif</td>
                                    <td>{{($correctionMasterData->approved_reason)}}</td>
                                    <td><a href="{{route('invoicecorrectionmaster.edit',$correctionMasterData->id)}}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" align="center">No Records Found!</td>
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
