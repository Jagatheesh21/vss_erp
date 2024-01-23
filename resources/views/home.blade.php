@extends('layouts.app')

@section('content')
    <div class="row">
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
                        <li class="list-group-item"><a href="{{route('supplier-products.index')}}">Purchase Order</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card border-secondary mb-3">
                <div class="card-header">Stores</div>
                <div class="card-body text-secondary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#">Material Inward (GRN)</a></li>
                        <li class="list-group-item"><a href="#">GRN Correction</a></li>
                        <li class="list-group-item"><a href="#">Material Issuance</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card border-secondary mb-3">
                <div class="card-header">CNC</div>
                <div class="card-body text-secondary">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
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
                        <li class="list-group-item"><a href="#">Incoming QA Clearance</a></li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
