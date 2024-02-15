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
                                    <th>Storage Area</th>
                                    <th>GRN Number</th>
                                    <th>Rack ID</th>
                                    <th>RM Category</th>
                                    <th>RM Description</th>
                                    <th>Total Inward Stock</th>
                                    <th>Total Quality Clearance Stock</th>
                                    <th>Total DC Issuance Stock</th>
                                    <th>Total Production Issuance Stock</th>
                                    <th>Total Rejection Stock</th>
                                    <th>Available Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inward_datas as $rackmaster_data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rackmaster_data->rackstockmaster->name}}</td>
                                    <td>{{$rackmaster_data->rack_name}}</td>
                                    <td>{{$rackmaster_data->category->name}}</td>
                                    <td>{{$rackmaster_data->material->name}}</td>
                                    <td>{{$rackmaster_data->material->minimum_stock}}</td>
                                    <td>{{$rackmaster_data->material->maximum_stock}}</td>
                                    <td>{{$available_stock}}</td>
                                    <td>@if ($rackmaster_data->status==1)
                                        <span class="btn btn-sm btn-success text-white">Active</span>
                                        @else
                                        <span class="btn btn-sm btn-danger text-white">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('grn_inward.edit',$rackmaster_data->id)}}" class="btn btn-sm btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp; Edit</a></td>
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
