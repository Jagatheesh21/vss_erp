@extends('layouts.app')
@push('styles')

@endpush
@section('content')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
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
        <div class="row col-md-3"id="res"></div>

        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>RM Issuance Register</b></span><a class="btn btn-sm btn-primary" href="{{route('rmissuance.index')}}">RM Issuance List</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rm_qc_id">Scan The GRN QR Code ID *</label>
                            <input type="text" name="rm_qc_id" id="rm_qc_id"  class="form-control @error('rm_qc_id') is-invalid @enderror" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off" autofocus>
                            @error('rm_qc_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <form action="{{route('rmissuance.storedata')}}" id="rm_issuance_formdata" method="POST">
                    @csrf
                    @method('POST')
                        <div class="row d-flex justify-content-center">
                            <input type="hidden" name="heat_id" id="heat_id">
                            <input type="hidden" name="grn_qc_id" id="grn_qc_id">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rc_no">Route Card Number *</label>
                                    <input type="text" name="rc_no" id="rc_no" value="{{$new_rcnumber}}" class="form-control bg-light @error('rc_no') is-invalid @enderror" @readonly(true)>
                                    @error('rc_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rc_date">Route Card Date *</label>
                                    <input type="date" name="rc_date" id="rc_date" value="{{$current_date}}" readonly class="form-control bg-light @error('rc_date') is-invalid @enderror" >
                                    @error('rc_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="grnnumber">GRN Number *</label>
                                    <select name="grnnumber" class="form-control bg-light @error('grnnumber') is-invalid @enderror" @readonly(true) id="grnnumber" >
                                    </select>
                                    @error('grnnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rm_id">RM Description *</label>
                                    <select name="rm_id" id="rm_id" class="form-control bg-light @error('rm_id') is-invalid @enderror" @readonly(true)>
                                    </select>
                                    @error('rm_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="uom_id">Unit Of Measurement (UOM) *</label>
                                    <select name="uom_id" id="uom_id" class="form-control bg-light @error('uom_id') is-invalid @enderror" @readonly(true)>
                                    </select>
                                    @error('uom_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="part_id">Part Number *</label>
                                    <select name="part_id" id="part_id" class="form-control @error('part_id') is-invalid @enderror">
                                    </select>
                                    @error('part_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="avl_qty">RM Available Stock *</label>
                                    <input type="number" name="avl_qty" id="avl_qty"  class="form-control bg-light @error('avl_qty') is-invalid @enderror" @readonly(true)>
                                    @error('avl_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="issue_qty">Issue Quantity *</label>
                                    <input type="number" name="issue_qty" id="issue_qty" min="0" class="form-control @error('issue_qty') is-invalid @enderror">
                                    @error('issue_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="heatnumber">Heat No *</label>
                                    <select name="heatnumber" id="heatnumber" @readonly(true) class="form-control bg-light  @error('heatnumber') is-invalid @enderror">
                                    </select>
                                    @error('heatnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lot_no">Lot Number *</label>
                                    <input type="text" name="lot_no" id="lot_no" @readonly(true) class="form-control  bg-light @error('lot_no') is-invalid @enderror" @readonly(true)>
                                    @error('lot_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="coil_no">Coil No *</label>
                                    <select name="coil_no" id="coil_no" @readonly(true) class="form-control  bg-light  @error('coil_no') is-invalid @enderror">
                                    </select>
                                    @error('coil_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tc_no">Test Certificate Number *</label>
                                    <input type="text" name="tc_no" id="tc_no" @readonly(true) class="form-control  bg-light @error('tc_no') is-invalid @enderror" @readonly(true)>
                                    @error('tc_no')
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
</form>
@endsection

@push('scripts')
<script>

$("#rm_qc_id").focus(function (e) {
    e.preventDefault();
    var rm_qc_id=$(this).val();
    $('#grn_qc_id').val(rm_qc_id);
    // alert(rm_qc_id);
    if (rm_qc_id!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('grnqcfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "rm_qc_id":rm_qc_id,
            },
            success: function (response) {
            // alert(response);
                if (response.count==1) {
                    if(response.success){
                        $('#grnnumber').html(response.grn_no);
                        $('#rm_id').html(response.rm_id);
                        // $('#part_id').html(response.part);
                        $('#heatnumber').html(response.heat_no);
                        $('#heat_id').val(response.heat_id);
                        $('#uom_id').html(response.uom);
                        $('#coil_no').html(response.coil_no);
                        $('#tc_no').val(response.tc_no);
                        $('#lot_no').val(response.lot_no);
                        $('#part_id').html(response.part);
                        $('#avl_qty').val(response.avl_qty);
                        $('#issue_qty').attr('max', response.avl_qty);
                        $('#rm_qc_id').prop('readonly', true);

                    } else {
                        var msg='Please Follow The FIFO ..Try GRN Number Is '+response.fifoGrn;
                        alert(msg);
                        location.reload(true);
                    }
                } else {
                    alert('Sorry This GRN Number is Not Approval From Incoming Quanlity And Try Another GRN Number');
                    return false;
                    location.reload(true);
                }
            }
        });
    }
});
$("#rm_qc_id").change(function (e) {
    e.preventDefault();
    var rm_qc_id=$(this).val();
    $('#grn_qc_id').val(rm_qc_id);

    // alert(rm_qc_id);
    if (rm_qc_id!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('grnqcfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "rm_qc_id":rm_qc_id,
            },
            success: function (response) {
            // alert(response);
                if (response.count==1) {
                    if(response.success){
                        $('#grnnumber').html(response.grn_no);
                        $('#rm_id').html(response.rm_id);
                        // $('#part_id').html(response.part);
                        $('#heatnumber').html(response.heat_no);
                        $('#heat_id').val(response.heat_id);
                        $('#uom_id').html(response.uom);
                        $('#coil_no').html(response.coil_no);
                        $('#tc_no').val(response.tc_no);
                        $('#lot_no').val(response.lot_no);
                        $('#part_id').html(response.part);
                        $('#avl_qty').val(response.avl_qty);
                        $('#issue_qty').attr('max', response.avl_qty);
                        $('#rm_qc_id').prop('readonly', true);

                    } else {
                        var msg='Please Follow The FIFO ..Try GRN Number Is '+response.fifoGrn;
                        alert(msg);
                        location.reload(true);
                    }
                } else {
                    alert('Sorry This GRN Number is Not Approval From Incoming Quanlity And Try Another GRN Number');
                    return false;
                    location.reload(true);
                }
            }
        });
    }
});

    $("#part_id").select2({
        placeholder:"Select Part Number",
        allowedClear:true
    });

    $("#reset").click(function (e) {
        e.preventDefault();
        location.reload(true);
    });


</script>
@endpush

