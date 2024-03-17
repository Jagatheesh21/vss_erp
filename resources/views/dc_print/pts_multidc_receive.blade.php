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
            <form action="#" method="post">
                @csrf
                @method('POST')
                <div class="card-header d-flex" style="justify-content:space-between"><span> <b>PTS Multi Delivery challan Receive Entry</b> </span>
                    <a class="btn btn-sm btn-info text-white" href="{{route('dcprint.create')}}">PTS Multi Delivery challan Receive List</a>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="s_no">DC S.No *</label>
                                <select name="s_no" id="s_no" class="form-control s_no  @error('s_no') is-invalid @enderror">
                                    <option value="" selected>Select DC S.No</option>
                                    @foreach ($multiDCDatas as $multiDCData)
                                    <option value="{{$multiDCData->s_no}}">{{'DC-U1-'.$multiDCData->s_no}}</option>
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
                                <button class="btn btn-primary text-white mt-4 downloadpdf" id="downloadpdf" style="display: none">Receive All</button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input select_all" name="select_all" id="select_all"></th>
                                        <th>DC Number</th>
                                        <th>DC Date</th>
                                        <th>Part No</th>
                                        <th>Issue Quantity</th>
                                        <th>UOM</th>
                                        <th>Receive Quantity</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
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
        $(".status").select2({
            placeholder:"Select Status",
            allowedClear:true
        });
        $("#s_no").change(function (e) {
            e.preventDefault();
            var s_no=$(this).val();
            // alert(s_no);
            $.ajax({
                type: "POST",
                url: "{{route('ptsdcmultireceivedata')}}",
                data: {"s_no":s_no},
                success: function (response) {
                    $('#table_logic').html(response.table);
                    $('#downloadpdf').show();
                }
            });
        });
        $('.sub_id').change(function (e) {
        e.preventDefault();
        // getRow();
        });

        $('.select_all').on('click', function(e) {
            if($(this).is(':checked',true))
            {
                $(".sub_id").prop('checked', true);
            } else {
                $(".sub_id").prop('checked',false);
            }
        });

        $('.status').change(function (event) {
            $(this).closest("tr").find('td .sub_id').prop('checked', true);
            var status=$(this).val();
            alert(status);

        });
</script>
@endpush
