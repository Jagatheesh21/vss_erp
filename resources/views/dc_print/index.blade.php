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
            <form action="{{route('dcmultipdf')}}" method="post">
                @csrf
                @method('POST')
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-info text-white mt-4 downloadpdf" id="downloadpdf" style="display: none">Download PDF</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>DC Number</th>
                                        <th>DC Date</th>
                                        <th>Part No</th>
                                        <th>Quantity</th>
                                        <th>UOM</th>
                                        <th>Unit Rate</th>
                                        <th>Total Value</th>
                                    </tr>
                                </thead>
                                <tbody id="table_logic">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
        $("#s_no").select2();
        $("#s_no").change(function (e) {
            e.preventDefault();
            var s_no=$(this).val();
            // alert(s_no);
            $.ajax({
                type: "POST",
                url: "{{route('dcmultiprintdata')}}",
                data: {"s_no":s_no},
                success: function (response) {
                    $('#table_logic').html(response.table);
                    $('#downloadpdf').show();
                }
            });
        });
</script>
@endpush
