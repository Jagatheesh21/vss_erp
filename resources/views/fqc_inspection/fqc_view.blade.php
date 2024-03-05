@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
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
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Final Quality Inspection Register List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('fqc_approval.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Offer Date</th>
                                    <th>Previous Stage</th>
                                    <th>Next Stage</th>
                                    <th>Part Number</th>
                                    <th>Route Card Number</th>
                                    <th>Previous Route Card Number</th>
                                    <th>Offered Qty</th>
                                    <th>Inspected Qty</th>
                                    <th>Approve Qty</th>
                                    <th>On-Hold Qty</th>
                                    <th>Rejection Qty</th>
                                    <th>Reason</th>
                                    <th>Inspected By</th>
                                    <th>Inspected Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fqcDatas as $fqcData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$fqcData->offer_date}}</td>
                                    <td>{{$fqcData->currentprocessmaster->operation}}</td>
                                    <td>{{$fqcData->nextprocessmaster->operation}}</td>
                                    <td>{{$fqcData->partmaster->child_part_no}}</td>
                                    <td>{{$fqcData->current_rcmaster->rc_id}}</td>
                                    <td>{{$fqcData->previous_rcmaster->rc_id}}</td>
                                    <td>{{$fqcData->offer_qty}}</td>
                                    <td>{{$fqcData->inspect_qty}}</td>
                                    <td>{{$fqcData->approve_qty}}</td>
                                    <td>{{$fqcData->rework_qty}}</td>
                                    <td>{{$fqcData->reject_qty}}</td>
                                    <td>{{$fqcData->reason}}</td>
                                    <td>@if (($fqcData->inspect_by!=NULL))
                                        {{$fqcData->inspector_usermaster->name}}
                                    @else
                                    @endif</td>
                                    <td>@if (($fqcData->inspect_date!=NULL))
                                        {{$fqcData->inspect_date}}
                                    @else
                                    @endif</td>
                                    <td>@if ($fqcData->status==0)
                                        <span class="btn btn-sm btn-info text-white">PENDING</span>
                                    @elseif ($fqcData->status==1)
                                        <span class="btn btn-sm btn-success text-white">APPROVED</span>
                                    @elseif ($fqcData->status==2)
                                        <span class="btn btn-sm btn-danger text-white">REJECTED</span>
                                        @else
                                        <span class="btn btn-sm btn-warning text-white">ON-HOLD</span>
                                    @endif</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="16" align="center">No Records Found!</td>
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
