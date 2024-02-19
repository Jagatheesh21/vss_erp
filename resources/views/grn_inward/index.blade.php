@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>GRN Material Inward Register List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('grn_inward.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
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
                                    <th>PO Number</th>
                                    <th>Supplier Code</th>
                                    <th>Supplier Name</th>
                                    <th>RM Category</th>
                                    <th>RM Description</th>
                                    <th>Total Inward Stock</th>
                                    <th>Total Incoming Quality Approved Stock</th>
                                    <th>Total Incoming Quality On Hold Stock</th>
                                    <th>Total Incoming Quality On Rejected Stock</th>
                                    <th>Total Production Issuance Stock</th>
                                    <th>Total RM Return Stock</th>
                                    <th>Total DC Issuance Stock</th>
                                    <th>Available Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inward_datas as $inward_data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$inward_data->grnnumber}}</td>
                                    <td>{{$inward_data->grndate}}</td>
                                    <td>{{$inward_data->ponumber}}</td>
                                    <td>{{$inward_data->sc_code}}</td>
                                    <td>{{$inward_data->sc_name}}</td>
                                    <td>{{$inward_data->rm_category}}</td>
                                    <td>{{$inward_data->rm_desc}}</td>
                                    <td>{{$inward_data->inward_qty}}</td>
                                    <td>{{$inward_data->approved_qty}}</td>
                                    <td>{{$inward_data->onhold_qty}}</td>
                                    <td>{{$inward_data->rejected_qty}}</td>
                                    <td>{{$inward_data->issued_qty}}</td>
                                    <td>{{$inward_data->return_qty}}</td>
                                    <td>{{$inward_data->return_dc_qty}}</td>
                                    <td>{{$inward_data->avl_qty}}</td>
                                    <td>@if ($inward_data->status==1)
                                        <span class="btn btn-sm btn-success text-white">Active</span>
                                        @else
                                        <span class="btn btn-sm btn-danger text-white">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('grn_inward.edit',$inward_data->id)}}" class="btn btn-sm btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp;</a></td>
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
