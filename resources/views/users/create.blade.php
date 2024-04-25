@extends('layouts.app')
@push('styles')

@endpush
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
        <div class="card-header d-flex" style="justify-content:space-between"><span><b>Create New User</b>  </span>
            <a class="btn btn-md btn-primary" href="{{route('userindex')}}"><b> User List</b></a>
        </div>
        <div class="row col-md-3"id="res"></div>
            <div class="card-body">
            <form action="{{route('userstore')}}" id="users_formdata" method="POST">
                @csrf
                @method('POST')

                <div class="row d-flex ">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="username">User ID *</label>
                            <input type="text" name="username" @readonly(true) class="form-control bg-light @error('username') is-invalid @enderror" value="{{$new_username}}">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">User Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="roles">Role *</label>
                            <select name="roles" id="roles" class="form-control @error('roles') is-invalid @enderror">
                                <option value="" selected>Selected The Role</option>
                                @forelse ($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @empty
                                @endforelse
                                </select>
                                @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row d-flex  ">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" >
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" onpaste="return false;" onCopy="return false;" onCut="return false;" onDrag="return false;" onDrop="return false;" autocomplete=off>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="submit" class="btn btn-success  text-white align-center" id="btn" value="Save">
                        <input class="btn btn-danger text-white" id="reset" type="reset" value="Reset">
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $("#roles").select2();

        $("#reset").click(function (e) {
            e.preventDefault();
            location.reload(true);
        });
    });
</script>
@endpush
