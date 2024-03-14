@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
        <div class="card">
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
            @if (session()->has('message'))
                <div class="alert alert-danger mt-4">
                {{ session()->get('message')}}
                </div>
            @endif
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Multi Delivery challan List</b> </span>
                <a class="btn btn-sm btn-info text-white" href="{{route('dcprint.create')}}">Multi DC Print</a>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="s_no">DC S.No *</label>
                            <select name="s_no" id="s_no" class="form-control s_no  @error('s_no') is-invalid @enderror">
                                <option value="" selected>Select DC S.No</option>
                                @foreach ($dcprintDatas as $dcprintData)
                                <option value="{{$dcprintData->s_no}}">{{'DC-U1-'.$dcprintData->s_no}}</option>
                                @endforeach
                            </select>
                            @error('s_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
        $("#s_no").select2();
        $("#s_no").change(function (e) {
            e.preventDefault();
            var dc_sno=$(this).val();
            alert(dc_sno);
        });
</script>
@endpush
