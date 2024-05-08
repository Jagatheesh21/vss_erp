@extends('layouts.app')
@section('content')
<div class="row bg-white p-3">
    <div class="d-flex justify-content-between">
    <h4>Roles</h4>
    <a href="{{route('roles.create')}}" class="btn btn-sm btn-success col-1 text-white m-2" style="align:right">Add Role</a>

</div>
<div class="row">
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
</div>
    <div class="table-responsive bg-white">
        <table class="table table-hovered table-bordered">
            <thead >
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$role->name}}</td>
                    <td><a class="btn btn-sm btn-primary mr-3" href="{{route('roles.edit',$role->id)}}">Edit</a>
                        <a class="btn btn-sm btn-danger text-white" href="{{route('role_permission',$role->id)}}">Assign Permissions</a></td>
                </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </div>
</div>
@endsection
