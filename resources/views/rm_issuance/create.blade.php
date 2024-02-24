@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('rmissuance.storedata')}}" id="rm_issuance_formdata" method="POST">
    @csrf
    @method('POST')

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
                                    <select name="grnnumber" class="form-control @error('grnnumber') is-invalid @enderror"  id="grnnumber">
                                        <option value="" selected></option>
                                        @foreach ($grnDatas as $grnData)
                                            <option value="{{$grnData->id}}" >{{$grnData->grnnumber}}</option>
                                        @endforeach
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
                                    <select name="part_id" id="part_id" class="form-control bg-light @error('part_id') is-invalid @enderror">
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
                                    <select name="heatnumber" id="heatnumber" class="form-control @error('heatnumber') is-invalid @enderror">
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
                                    <input type="text" name="lot_no" id="lot_no" class="form-control  bg-light @error('lot_no') is-invalid @enderror" @readonly(true)>
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
                                    <select name="coil_no" id="coil_no" class="form-control @error('coil_no') is-invalid @enderror">
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
                                    <input type="text" name="tc_no" id="tc_no" class="form-control  bg-light @error('tc_no') is-invalid @enderror" @readonly(true)>
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
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('input').on('input', function() {
        var inputId = $(this).attr('id');
        $('#' + inputId + '-error').remove();
    });
    updateGrandTotal();
    // getRow();
});
$("#grnnumber").select2({
        placeholder:"Select GRN Number",
        allowedClear:true
    });
    $("#part_id").select2({
        placeholder:"Select Part Number",
        allowedClear:true
    });
$("#heatnumber").select2({
        placeholder:"Select Heat Number",
        allowedClear:true
    });
    $("#coil_no").select2({
        placeholder:"Select Coil Number",
        allowedClear:true
    });
$('.sub_id').change(function (e) {
    e.preventDefault();
    getRow();
});

    $("#reset").click(function (e) {
        e.preventDefault();
        location.reload(true);
    });

    $('#grnnumber').change(function (e) {
        e.preventDefault();
        var grn_id=$(this).val();
        // alert(grn_id);
        if (grn_id!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('grnrmfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "grn_id":grn_id,
            },
            success: function (response) {
                console.log(response);
                $('#rm_id').html(response.rm);
                $('#part_id').html(response.part);
                $('#heatnumber').html(response.heat_no);
                $('#uom_id').html(response.uom);
            }
        });
        }
    });

    $('#heatnumber').change(function (e) {
        e.preventDefault();
        var grn_id=$('#grnnumber').val();
        var heat_id=$(this).val();
        if (heat_id!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('grnheatfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "grn_id":grn_id,
                "heat_id":heat_id,
            },
            success: function (response) {
                console.log(response);
                if(response.count > 0){
                    $('#coil_no').html(response.coil_no);
                }else{
                    alert('There Is No Available Coil in this heat number ,So Please Try Another Heat Number');
                    return false;
                }
            }
        });
        }
    });

    $('#coil_no').change(function (e) {
        e.preventDefault();
        var grn_id=$('#grnnumber').val();
        var heat_id=$('#heatnumber').val();
        var coil_no=$('#coil_no').val();
        if (coil_no!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('grncoilfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "grn_id":grn_id,
                "heat_id":heat_id,
                "coil_no":coil_no,
            },
            success: function (response) {
                console.log(response);
                if(response.count > 0){
                    $('#tc_no').val(response.tc_no);
                    $('#lot_no').val(response.lot_no);
                    $('#avl_qty').val(response.avl_qty);
                    $('#heat_id').val(response.heat_id);
                    $('#grn_qc_id').val(response.grn_qc_id);
                    $('#issue_qty').attr('max', response.avl_qty);
                }else{
                    alert('There Is No Available Coil in this heat number ,So Please Try Another Heat Number');
                    return false;
                }
            }
        });
        }
    });

</script>
@endpush

