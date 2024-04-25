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
    @if(Session::has('message'))
        <div class="alert alert-danger mt-4">
        {{ Session::get('message')}}
        </div>
    @endif
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>QR Code Lock List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('stageqrcodelock.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Stage</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($qrlockDatas as $qrlockData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$qrlockData->stage}}</td>
                                    <td>{{$qrlockData->activity}}</td>
                                    <td>@if ($qrlockData->status==1)
                                        <span class="btn btn-sm btn-success text-white">Active</span>
                                        @else
                                        <span class="btn btn-sm btn-danger text-white">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('stageqrcodelock.edit',$qrlockData->id)}}" class="btn btn-sm btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp; Edit</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" align="center">No Records Found!</td>
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
