@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Edit Role</div>
            <div class="card-body">
                <form class="form" action="{{route('roles.update',$role->id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="col-md-4">
                        <div class="form-group">
                            <label >Name *</label>
                            <input type="text" name="name" class="form-control" value="{{$role->name}}">
                        </div>
                    </div>
                    <div class="col-md-2 col-offset-8 mt-4">
                        <button type="submit" class="form-control btn btn-sm btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection