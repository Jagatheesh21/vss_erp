@extends('layouts.app')

@section('content')
    <div class="row">

        {{-- User Mangement --}}
        @role('Super Admin')
        <div class="col-3">
            <div class="card border-primary mb-3">
                <div class="card-header">User Mangement</div>
                <div class="card-body text-primary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{route('userindex')}}">User Management</a></li>
                        <li class="list-group-item"><a href="{{route('roles.index')}}">Roles</a></li>
                        <li class="list-group-item"><a href="{{route('permissions.index')}}">Permissions</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endrole
        {{-- User Management --}}
        <div class="col-3">
            <div class="card border-primary mb-3">
                <div class="card-header">Purchase Order</div>
                <div class="card-body text-primary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{route('department.index')}}">Department</a></li>
                        <li class="list-group-item"><a href="{{route('raw_material_category.index')}}">Raw Material Category</a></li>
                        <li class="list-group-item"><a href="{{route('raw_material.index')}}">Raw Materials</a></li>
                        <li class="list-group-item"><a href="{{route('supplier.index')}}">Suppliers</a></li>
                        <li class="list-group-item"><a href="{{route('supplier-products.index')}}">Supplier Products</a></li>
                        <li class="list-group-item"><a href="{{route('po.index')}}">Purchase Order</a></li>
                        <li class="list-group-item"><a href="{{route('po-correction.index')}}">Purchase Order Correction</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card border-secondary mb-3">
                <div class="card-header">Stores</div>
                <div class="card-body text-secondary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{route('grn_inward.index')}}">Material Inward (GRN)</a></li>
                        {{-- <li class="list-group-item"><a href="#">GRN Correction</a></li> --}}
                        <li class="list-group-item"><a href="{{route('rmissuance.index')}}">Material Issuance</a></li>
                        <li class="list-group-item"><a href="{{route('retrunrmdetails.index')}}">Return Raw Material Receipt</a></li>
                        <li class="list-group-item"><a href="{{route('sfreceive')}}">Semi-Finished Material Receive</a></li>
                        <li class="list-group-item"><a href="{{route('sfissue')}}">Semi-Finished Material Issuance</a></li>
                        <li class="list-group-item"><a href="{{route('osreceive')}}">Out-Store Material Receive</a></li>
                        <li class="list-group-item"><a href="{{route('delivery_challan.create')}}">DC Issuance</a></li>
                        <li class="list-group-item"><a href="{{route('ptsinwarddata')}}">PTS Material Receive</a></li>
                        <li class="list-group-item"><a href="{{route('ptsproductionreceive')}}">PTS Production Receive</a></li>
                        <li class="list-group-item"><a href="{{route('fgreceive')}}">Finished Goods Material Receive</a></li>
                        <li class="list-group-item"><a href="{{route('rack-stockmaster.index')}}">Stocking Point Rack Master</a></li>
                        <li class="list-group-item"><a href="{{route('rackmaster.index')}}">Rack Master</a></li>
                        <li class="list-group-item"><a href="{{route('process-master.index')}}">Item Process Master</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card border-secondary mb-3">
                <div class="card-header">Sales</div>
                <div class="card-body text-secondary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{route('customermaster.index')}}">Customer Master</a></li>
                        <li class="list-group-item"><a href="{{route('customer-products.index')}}">Customer Product Master</a></li>
                        <li class="list-group-item"><a href="{{route('invoicedetails.index')}}">Invoice Details</a></li>
                        <li class="list-group-item"><a href="{{route('invoicecorrectionmaster.index')}}">Invoice Correction Approval</a></li>
                        <li class="list-group-item"><a href="{{route('invoicecorrectionform')}}">Invoice Correction</a></li>
                        <li class="list-group-item"><a href="{{route('supplymentaryinvoice')}}">Supplymentary Invoice</a></li>
                        <li class="list-group-item"><a href="{{route('stageqrcodelock.index')}}">QR Code Lock</a></li>
                        <li class="list-group-item">A third item</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card border-secondary mb-3">
                <div class="card-header">Quality</div>
                <div class="card-body text-secondary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{route('grn_qc.index')}}">Incoming QA Clearance</a></li>
                        <li class="list-group-item"><a href="{{route('fqc_approval.index')}}">Final QA Clearance</a></li>
                        <li class="list-group-item"><a href="{{route('ptsfqclist')}}">PTS Final QA Clearance</a></li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
