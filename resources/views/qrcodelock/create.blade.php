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
        <div class="card-header d-flex justify-content-space-around">
            <div class="col-md-8"><b>Create QR Code Lock</b></div>
            <div class="col-md-4"><a class="btn btn-sm btn-primary" href="{{route('stageqrcodelock.index')}}">QR Code Lock List</a></div>
        </div>
        <div class="row col-md-3"id="res"></div>

            <div class="card-body">
            <form action="{{route('stageqrcodelock.store')}}" id="stageqrcodelock_formdata" method="POST">
                @csrf
                @method('POST')

                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stage">Stage *</label>
                            <input type="text" name="stage" class="form-control @error('stage') is-invalid @enderror" >
                            @error('stage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="activity">Activity *</label>
                            <input type="text" name="activity" class="form-control @error('activity') is-invalid @enderror" >
                            @error('activity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center ">
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
        $("#reset").click(function (e) {
            e.preventDefault();
            location.reload(true);
        });
    });
</script>
@endpush
