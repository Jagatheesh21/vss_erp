@extends('layouts.auth')

@section('content')
<div class="col-lg-5">
    <div class="card-group d-block d-md-flex row">
        <div class="card col-md-6 p-4 mb-0">
        <form method="POST" action="{{ route('login') }}">
            @csrf
        <div class="card-body">
            <h1 class="text-center">Login</h1>
            <p class="text-medium-emphasis text-center">Sign In to your account</p>
            <div class="input-group mb-3"><span class="input-group-text">
                <svg class="icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                </svg></span>
            <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="Employee Code" value="{{ old('username') }}" required autocomplete="off" autofocus>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="input-group mb-4"><span class="input-group-text">
                <svg class="icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                </svg></span>
            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary px-4" type="submit">{{ __('Login') }}</button>
                </div>
                <!-- <div class="col-6 text-end">
                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                </div> -->
            </div>
        </div>
        </form>
        </div> 
    </div>
</div>
@endsection
