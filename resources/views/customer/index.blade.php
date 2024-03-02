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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Customer List</b> </span>
                <a class="btn btn-sm btn-primary" href="{{route('customer.create')}}">Add Customer</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Code</th>
                                    <th>Customer Name</th>
                                    <th>Customer Address</th>
                                    <th>Customer City</th>
                                    <th>Customer State</th>
                                    <th>Customer Country</th>
                                    <th>Customer Pincode</th>
                                    <th>Supplier Vendor Code</th>
                                    <th>Supplier Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customerDatas as $customerData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$customerData->cus_code}}</td>
                                    {{-- <td>{{$customerData->cus_type}}</td> --}}
                                    <td>{{$customerData->cus_name}}</td>
                                    <td>{{$customerData->cus_address}}</td>
                                    <td>{{$customerData->cus_city}}</td>
                                    <td>{{$customerData->cus_state}}</td>
                                    <td>{{$customerData->cus_country}}</td>
                                    <td>{{$customerData->cus_pincode}}</td>
                                    <td>{{$customerData->supplier_vendor_code}}</td>
                                    <td>{{$customerData->supplytype}}</td>
                                    <td>@if ($customerData->status==1)
                                        <span class="btn btn-sm text-white btn-success">Active</span>
                                        @else
                                        <span class="btn btn-sm text-white btn-danger">Inactive</span>
                                    @endif</td>
                                    <td><a href="{{route('customer.edit',$customerData->id)}}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" align="center">No Records Found!</td>
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
