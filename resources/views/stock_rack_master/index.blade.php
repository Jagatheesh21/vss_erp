@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Stocking Point Rack Master List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('rack-stock-master.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stockmasters as $stockmaster)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$stockmaster->name}}</td>
                                    <td>@if ($stockmaster->status==1)
                                        <span class="btn btn-sm btn-success">Active</span>
                                        @else
                                        <span class="btn btn-sm btn-danger">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('rack-stock-master.edit',$stockmaster->id)}}" class="btn btn-sm btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp;&nbsp; Edit</a></td>
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
