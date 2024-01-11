@extends('layouts.app')
@section('content')
<div class="row bg-white">
    <h4>Roles</h4>
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
                    <td><a class="btn btn-sm btn-primary mr-3" href="{{route('roles.edit',$role->id)}}">Edit</a> <a class="btn btn-sm btn-danger" href="{{route('roles.destroy',$role->id)}}">Delete</a></td>
                </tr>    
                @empty
                    
                @endforelse
                
            </tbody>
        </table>
    </div>
</div>
@endsection