@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex text-center" style="justify-content:space-around"><b>Material Updation</b><a href="{{route('raw_material.index')}}" class="btn btn-sm btn-primary">Material List</a></div>
            <div class="card-body">
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
                <form action="{{route('raw_material.update',$rawMaterial->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                  <input type="hidden" name="id" value="{{$rawMaterial->id}}">

                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Category *</label>
                                <select name="raw_material_category_id" id="" class="form-control">
                                    <option value=""></option>
                                    @forelse ($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id==$rawMaterial->raw_material_category_id) selected @endif>{{$category->name}}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Material Description *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$rawMaterial->name}}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Material Code *</label>
                                <input type="text" name="material_code"  value="{{$rawMaterial->material_code}}" readonly class="form-control bg-light @error('material_code') is-invalid @enderror" >
                                @error('material_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Minimum Stock *</label>
                                <input type="number" name="minimum_stock" min="0.10" step="0.01" value="{{$rawMaterial->minimum_stock}}" class="form-control @error('minimum_stock') is-invalid @enderror" >
                                @error('minimum_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status *</label>
                                <select name="status" class="form-control">
                                    <option value="1" @if($rawMaterial->status==1) selected @endif >Active</option>
                                    <option value="0" @if($rawMaterial->status==0) selected @endif>Inactive</option>
                                </select>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2 mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection