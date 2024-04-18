@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Add Permission</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('permissions.index')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>Permissions</b></a>
            </div>
            <div class="card-body">
                <form  action="{{route('permissions.store')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-5">
                            <label for="">Name </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" required="true" name="name" value="{{old('name')}}">
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-2 mt-4">
                            <button class="btn btn-sm btn-success text-white" type="submit">Submit</button>
                        </div>
                    </div>
                    

                </form>
            </div>
        </div>
    </div>
</div>
@endsection