@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> Department List </span>
                <a class="btn btn-sm btn-primary" href="{{route('department.create')}}">Add Department</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>                                
                                <th>Status</th>                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$department->name}}</td>
                                <td>@if ($department->status==1)
                                    <span class="btn btn-sm btn-success">Active</span>
                                    @else
                                    <span class="btn btn-sm btn-danger">Inactive</span>
                                @endif</td>
                                <td><a href="{{route('department.edit',$department->id)}}" class="btn btn-sm btn-primary">Edit</a></td>
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
@endsection