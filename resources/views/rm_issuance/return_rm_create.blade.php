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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Return RM Receive Register</b></span><a class="btn btn-sm btn-primary" href="{{route('retrunrmdetails.index')}}">Return RM Receive List</a></div>
            <div class="card-body">
                @if ($qrCodes_count!=0)
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="scan_rc_id">Scan Route Card ID *</label>
                            <input type="text" name="scan_rc_id" id="scan_rc_id"  class="form-control @error('scan_rc_id') is-invalid @enderror" autofocus>
                            @error('scan_rc_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                @else

                @endif
                <form action="{{route('retrunrmdetails.store')}}" id="sf_receive_formdata" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row d-flex justify-content-center">
                        <input type="hidden" name="next_process_id" id="next_process_id" value="2">
                        <input type="hidden" name="qrcodes_count" id="qrcodes_count" value="{{$qrCodes_count}}">
                        <input type="hidden" name="qr_rc_id" id="qr_rc_id">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rc_no">Route Card Number *</label>
                                <select name="rc_no" class="form-control @error('rc_no') is-invalid @enderror" @if ($qrCodes_count!=0)
                                    @disabled(true)
                                @else
                                    @disabled(false)
                                @endif id="rc_no">
                                    <option value="" selected></option>
                                    @foreach ($d11Datas as $d11Data)
                                        <option value="{{$d11Data->rcmaster->id}}" >{{$d11Data->rcmaster->rc_id}}</option>
                                    @endforeach
                                </select>
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
                                <label for="part_id">Part Number *</label>
                                <select name="part_id" id="part_id" class="form-control bg-light @error('part_id') is-invalid @enderror" @readonly(true)>
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
                                <label for="current_process_id">Stocking Point *</label>
                                <select name="current_process_id" id="current_process_id" class="form-control bg-light @error('current_process_id') is-invalid @enderror" @readonly(true)>
                                </select>
                                @error('current_process_id')
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
                                <label for="rm_id">RM Desc *</label>
                                <select name="rm_id" id="rm_id"  class="form-control bg-light @error('rm_id') is-invalid @enderror" @readonly(true)>
                                </select>
                                @error('rm_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="grn_no">GRN No *</label>
                                <select name="grn_no" id="grn_no" class="form-control bg-light @error('grn_no') is-invalid @enderror" @readonly(true)>
                                </select>
                                @error('grn_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="heat_no">Heat No *</label>
                                <select name="heat_no" id="heat_no" class="form-control bg-light @error('heat_no') is-invalid @enderror" @readonly(true)>
                                </select>
                                @error('heat_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="coil_no">Coil No *</label>
                                <input type="text" name="coil_no" id="coil_no" @readonly(true) required class="form-control bg-light @error('coil_no') is-invalid @enderror">
                                @error('coil_no')
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
                                <label for="lot_no">Lot No *</label>
                                <input type="text" name="lot_no" id="lot_no" required @readonly(true) class="form-control bg-light @error('lot_no') is-invalid @enderror">
                                @error('lot_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tc_no">T.C No *</label>
                                <input type="text" name="tc_no" id="tc_no" required @readonly(true) class="form-control bg-light @error('tc_no') is-invalid @enderror">
                                @error('tc_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="avl_kg">Available Stock (In KG) *</label>
                                <input type="number" name="avl_kg" id="avl_kg" class="form-control bg-light @error('avl_kg') is-invalid @enderror" @readonly(true)>
                                @error('avl_kg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="receive_kg">Receive Quantity IN KG *</label>
                                <input type="number" name="receive_kg" id="receive_kg" required min="0" step="0.01" class="form-control @error('receive_kg') is-invalid @enderror">
                                @error('receive_kg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="reason">Reason</label>
                            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" cols="30" rows="5"></textarea>
                            @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-md-3">
                            <p><b>Route Card Close :</b></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rc_close" id="inlineRadio1" value="yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rc_close" id="inlineRadio2" checked  value="no">
                                <label class="form-check-label" for="inlineRadio2">No</label>
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
    $('input').on('input', function() {
        var inputId = $(this).attr('id');
        $('#' + inputId + '-error').remove();
    });
    $('#inlineRadio1').hide();

});

    $("#rc_no").select2({
        placeholder:"Select Route Card Number",
        allowedClear:true
    });


    $("#reset").click(function (e) {
        e.preventDefault();
        location.reload(true);
    });

    $('#scan_rc_id').change(function (e) {
        e.preventDefault();
        var rc_no=$(this).val();
        // alert(rc_no);
        if (rc_no!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('sfpartfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "rc_no":rc_no,
            },
            success: function (response) {
                // console.log(response);
                if(response.success){
                    if (response.process) {
                        if(response.message){
                        $('#part_id').html(response.part);
                        $('#rm_id').html(response.rm);
                        $('#grn_no').html(response.grn_datas);
                        $('#heat_no').html(response.heat_no_datas);
                        $('#heat_no').html(response.heat_no_datas);
                        $('#heat_no').html(response.heat_no_datas);
                        $('#avl_kg').val(response.avl_kg);
                        $('#receive_kg').attr('max', response.avl_kg);
                        $('#rc_no').html(response.rc_data);
                        $('#qr_rc_id').val(response.qr_rc_id);
                        }else{
                            alert('This Part Number is Not connected Item Process Master..So Please Contact Mr.PPC/ERP Team');
                        }
                    } else {
                        alert('This Part Number Process is Not connected SemiFinished Store..So Please Contact Mr.PPC/ERP Team');
                    }
                }else{
                    var msg='Please Follow The FIFO ..Try RC No Is '+response.fifoRcCard;
                    alert(msg);
                    location.reload(true);
                }
            }
        });
        }
    });
    $('#rc_no').change(function (e) {
        e.preventDefault();
        var rc_no=$(this).val();
        // alert(rc_no);
        if (rc_no!='') {
            $.ajax({
            type: "POST",
            url: "{{ route('rmreturnpartfetchdata') }}",
            data:{
                "_token": "{{ csrf_token() }}",
                "rc_no":rc_no,
            },
            success: function (response) {
                console.log(response);
                if(response.success){
                    $('#part_id').html(response.part);
                    $('#rm_id').html(response.rm);
                    $('#grn_no').html(response.grn_datas);
                    $('#heat_no').html(response.heat_no_datas);
                    $('#coil_no').val(response.coil_no);
                    $('#lot_no').val(response.lot_no);
                    $('#tc_no').val(response.tc_no);
                    $('#avl_kg').val(response.avl_kg);
                    $('#receive_kg').val(response.avl_kg);
                    $('#receive_kg').attr('max', response.avl_kg);
                    $('#receive_kg').attr('min', 0);
                    $('#current_process_id').html(response.operation);
                    $('#rc_no').html(response.rc_data);
                    $('#qr_rc_id').val(response.qr_rc_id);
                    $("#inlineRadio1").prop('checked', true);
                    $('#inlineRadio1').show();
                }else{
                    var msg='Sorry This Route Card is Already Used And Closed.Please Try Another Route Card...';
                    alert(msg);
                    location.reload(true);
                }
            }
        });
        }
    });

    $('#receive_kg').change(function (e) {
        e.preventDefault();
        var avl_kg=$('#avl_kg').val();
        var receive_kg=$(this).val();
        if (avl_kg!=''&&receive_kg!='') {
                var diff=avl_kg-receive_kg;
                // alert(diff);
                if (diff<0) {
                    alert('Your entering the wrong quantity when comparing available quantity...');
                    $('#inlineRadio1').hide();
                    $("#inlineRadio2").prop('checked', true);
                }if(diff>0.90){
                    $('#inlineRadio1').hide();
                    $("#inlineRadio2").prop('checked', true);
                }if(diff==0){
                    $('#inlineRadio1').show();
                    $("#inlineRadio1").prop('checked', true);
                }if (diff>0) {
                    $('#inlineRadio1').hide();
                    $("#inlineRadio2").prop('checked', true);
                }
                else{
                    $('#inlineRadio1').show();
                    $("#inlineRadio2").prop('checked', true);
                }
        }else{
            alert('Please Check The Receive Weight And Available Weight...');
            $('#inlineRadio1').hide();
        }
    });

</script>
@endpush

