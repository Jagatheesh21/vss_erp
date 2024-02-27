@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>RM Issuance Register List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('rmissuance.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Route Card Number</th>
                                    <th>Route Card Date</th>
                                    <th>GRN Number</th>
                                    <th>Heat Number</th>
                                    <th>Coil Number</th>
                                    <th>Test Certificate Number</th>
                                    <th>RM Desc</th>
                                    <th>Issue Qty</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($d12Datas as $d12Data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$d12Data->rc_no}}</td>
                                    <td>{{$d12Data->open_date}}</td>
                                    <td>{{$d12Data->previous_rc_no}}</td>
                                    <td>{{$d12Data->heatnumber}}</td>
                                    <td>{{$d12Data->coil_no}}</td>
                                    <td>{{$d12Data->tc_no}}</td>
                                    <td>{{$d12Data->rm_desc}}</td>
                                    <td>{{$d12Data->rm_issue_qty}}</td>
                                    <td>@if ($d12Data->status==1)
                                        <span class="btn btn-sm btn-success text-white">Active</span>
                                        @else
                                        <span class="btn btn-sm btn-danger text-white">Inactive</span>
                                    @endif</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="18" align="center">No Records Found!</td>
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
