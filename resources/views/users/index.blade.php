@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
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
    @if(Session::has('message'))
        <div class="alert alert-danger mt-4">
        {{ Session::get('message')}}
        </div>
    @endif
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>User List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('usercreate')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User Id</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userDatas as $userData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$userData->username}}</td>
                                    <td>{{$userData->name}}</td>
                                    <td>{{$userData->email}}</td>
                                    <td>{{$userData->role}}</td>
                                    {{-- <td><a href="{{ url('user-management/'.$userData->user_id.'/edit') }}"class="btn btn-sm btn-info"><i class='bx bxs-edit' style='color:white;'>&nbsp; Edit</a></td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" align="center">No Records Found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/boxicons.js')}}"></script>
@endsection
