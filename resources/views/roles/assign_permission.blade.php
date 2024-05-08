@extends('layouts.app')
@section('content')
<div class="row bg-white p-3">
    <div class="d-flex justify-content-between">
    <h4>Assign Permission</h4>
    <a href="{{route('roles.index')}}" class="btn btn-sm btn-success col-1 text-white m-2" style="align:right">Roles</a>
    </div>
    <div class="col-md-12">
        <form action="{{route('assign_permission')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="role_id" value="{{$role->id}}">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" readonly value="{{$role->name}}" class="form-control">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    @foreach($permissions as $permission)
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission->name}}" @if(in_array($permission->id,$role_permissions)) checked @endif>
                            <label class="form-check-label" for="flexSwitchCheckChecked">{{$permission->name}}</label>
                          </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <button type="submit" class="btn btn-md btn-success text-white mt-5">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
