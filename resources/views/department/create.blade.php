@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-8 ">
        <div class="card " >
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
        <div class="card-header d-flex justify-content-space-around">
            <div class="col-md-8">Create Department</div>
            <div class="col-md-4"><a class="btn btn-sm btn-primary" href="{{route('department.index')}}">Department List</a></div>
        </div>
            <div class="card-body">
            <form action="{{route('department.store')}}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-2 mt-4 text-center">
                        <button type="submit" class="form-control btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection