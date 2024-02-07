@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Purchase Order Correction List</b> </span>
                {{-- <a class="btn btn-sm btn-primary" href="{{route('po.create')}}">New Purchase Order Creation</a> --}}
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Correction PO Number</th>
                                    <th>Correction PO Date</th>
                                    <th>Request Reason</th>
                                    <th>Approved By</th>
                                    <th>Approved Date</th>
                                    <th>Approved Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pocorrection_datas as $pocorrection)
                                <tr>

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$pocorrection->podetails->ponumber}}</td>
                                    <td>{{date('d-m-Y', strtotime($pocorrection->po_corrections_date))}}</td>
                                    <td>{{$pocorrection->request_reason}}</td>
                                    <td>
                                        @if ($pocorrection->status==0)
                                        @else
                                        @foreach ($user_datas as $user_data)
                                            @if ($pocorrection->approved_by==$user_data->id)
                                            {{$user_data->name}}
                                            @else

                                            @endif
                                        @endforeach
                                        @endif</td>
                                    <td>
                                        @if ($pocorrection->status==0)
                                        00-00-0000
                                        @else
                                        {{date('d-m-Y', strtotime($pocorrection->approved_date))}}@endif</td>
                                    <td>{{$pocorrection->approve_reason}}</td>
                                    <td>@if ($pocorrection->status==0)
                                        <span class="btn btn-sm text-white btn-warning">PENDING</span>
                                    @elseif ($pocorrection->status==2)
                                    <span class="btn btn-sm text-white btn-danger">REJECTED</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-success">APPROVED</span>
                                    @endif</td>
                                    <td>
                                        @if ($pocorrection->status==0)
                                        {{-- <a href="{{route('pocorrection.approval',$pocorrection->id)}}" data-toggle="tooltip"  data-id="{{$pocorrection->id}}" data-original-title="Edit" class="edit btn btn-info mx-2 btn-sm text-white">Waiting For Approval</a> --}}
                                        <a href="{{route('po-correction.edit',$pocorrection->id)}}" class="edit btn btn-info mx-2 btn-sm text-white"><i class='bx bxs-edit' style='color:white;'  ></i> Waiting For Approval</a>
                                        @else
                                        @endif

                                        {{-- <a href="{{route('po.print',$po_data->id)}}"  data-toggle="tooltip"  data-id="{{$po_data->id}}" data-original-title="Edit" class="edit btn btn-info mx-2 btn-sm text-white">Print</a> --}}
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
<script src="{{asset('js/boxicons.js')}}"></script>

@endsection



