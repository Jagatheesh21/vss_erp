@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-around">Edit Category <a href="{{route('raw_material_category.index')}}" class="btn btn-sm btn-primary">Material Category List</a></div>
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
                <form action="{{route('raw_material_category.update',$rawMaterialCategory->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$rawMaterialCategory->name}}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status *</label>
                                <select name="status" class="form-control">
                                    <option value="1" @if($rawMaterialCategory->status==1) selected @endif >Active</option>
                                    <option value="0" @if($rawMaterialCategory->status==0) selected @endif>Inactive</option>
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