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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Supplier List</b> </span>
                <a class="btn btn-sm btn-primary" href="{{route('supplier.create')}}">Add Supplier</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Code</th>
                                    <th>Supplier Name</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$supplier->supplier_code}}</td>
                                    <td>{{$supplier->name}}</td>
                                    <td>{{$supplier->contact_number}}</td>
                                    <td>{{$supplier->address}}</td>
                                    <td>@if ($supplier->status==1)
                                        <span class="btn btn-sm text-white btn-success">Active</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-danger">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('supplier.edit',$supplier->id)}}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" align="center">No Records Found!</td>
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
