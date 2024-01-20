@extends('layouts.app')
@section('content')
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
            <div class="card-header d-flex" style="justify-content:space-between"><span> RawMaterial List </span>
                <a class="btn btn-sm btn-primary" href="{{route('raw_material.create')}}">Add RawMaterial</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Category</th>                                
                                    <th>Material Code</th>                                
                                    <th>Material Description</th>                             
                                    <th>Minimum Stock</th>                             
                                    <th>Available Stock</th>                             
                                    <th>Stock Level</th>                             
                                    <th>Status</th>                                
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($raw_materials as $department)                               
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$department->category->name}}</td>
                                    <td>{{$department->material_code}}</td>
                                    <td>{{$department->name}}</td>
                                    <td>{{$department->minimum_stock}}</td>
                                    <td>{{$avl_stock}}</td>
                                    <td>
                                        @if((($avl_stock)-($department->minimum_stock))==0)
                                        <span class="btn btn-sm text-white btn-warning">Low</span>
                                        @elseif((($avl_stock)-($department->minimum_stock))>0)
                                        <span class="btn btn-sm text-white btn-success">High</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-danger">Very Low</span>
                                    @endif</td>
                                    <td>@if ($department->status==1)
                                        <span class="btn btn-sm text-white btn-success">Active</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-danger">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('raw_material.edit',$department->id)}}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>    
                                @empty
                                <tr>
                                    <td colspan="5" align="center">No Records Found!</td>
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