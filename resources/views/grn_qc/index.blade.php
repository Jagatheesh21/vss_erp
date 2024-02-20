@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>GRN Material Incoming Quality Register List</b>  </span>
                {{-- <a class="btn btn-md btn-primary" href="{{route('grn_qc.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a> --}}
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>GRN Number</th>
                                    <th>GRN Date</th>
                                    <th>Supplier Name</th>
                                    <th>RM Category</th>
                                    <th>RM Description</th>
                                    <th>Rack ID</th>
                                    <th>Heat Number</th>
                                    <th>Test Certificate Number</th>
                                    <th>Coil Number</th>
                                    <th>Lot Number</th>
                                    <th>Total Approved Quantity</th>
                                    <th>Total On-Hold Quantity</th>
                                    <th>Total Rejected Quantity</th>
                                    <th>Inspected By</th>
                                    <th>Inspected Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($grnqc_datas as $grnqc_data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$grnqc_data->grnnumber}}</td>
                                    <td>{{$grnqc_data->grndate}}</td>
                                    <td>{{$grnqc_data->sc_name}}</td>
                                    <td>{{$grnqc_data->rm_category}}</td>
                                    <td>{{$grnqc_data->rm_desc}}</td>
                                    <td>{{$grnqc_data->rack_name}}</td>
                                    <td>{{$grnqc_data->heatnumber}}</td>
                                    <td>{{$grnqc_data->tc_no}}</td>
                                    <td>{{$grnqc_data->coil_no}}</td>
                                    <td>{{$grnqc_data->lot_no}}</td>
                                    <td>{{$grnqc_data->approved_qty}}</td>
                                    <td>{{$grnqc_data->onhold_qty}}</td>
                                    <td>{{$grnqc_data->rejected_qty}}</td>
                                    <td>{{$grnqc_data->inspected_by}}</td>
                                    <td>{{$grnqc_data->inspected_date}}</td>
                                    <td>@if ($grnqc_data->status==0)
                                        <span class="btn btn-sm btn-info text-white">PENDING</span>
                                    @elseif ($grnqc_data->status==1)
                                        <span class="btn btn-sm btn-success text-white">APPROVED</span>
                                    @elseif ($grnqc_data->status==2)
                                        <span class="btn btn-sm btn-danger text-white">REJECTED</span>
                                        @else
                                        <span class="btn btn-sm btn-warning text-white">ON-HOLD</span>
                                    @endif</td>
                                    <td class="me-auto">
                                        <a href="{{route('grn_qc.show',$grnqc_data->id)}}"  class="btn btn-sm py-0 mx-2 btn-primary"><i class='bx bxs-show' style='color:white;'>&nbsp;</i></a>
                                        @if ($grnqc_data->status!=1)
                                        {{-- <a href="{{route('grn_qc.edit',$grnqc_data->id)}}" class="btn btn-sm py-0 mx-2 btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp;</i></a> --}}
                                        <a href="{{route('grn_iqc.approval',$grnqc_data->grn_id)}}" data-toggle="tooltip"  data-id="{{$grnqc_data->id}}" class="btn btn-sm py-0 mx-2 btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp;</i></a>
                                        @else
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="14" align="center">No Records Found!</td>
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
