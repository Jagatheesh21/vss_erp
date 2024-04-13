@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> Create Invoice Correction</span>
                <a class="btn btn-sm btn-primary" href="{{route('invoicecorrectionmaster.index')}}">Invoice List</a>
            </div>
            <div class="row col-md-3"id="res"></div>

            <div class="card-body">

                    <form action="{{route('invoicecorrectionmaster.store')}}" id="invoicecorrection_formdata"  method="POST">
                        @csrf
                        @method('POST')
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice Number *</label>
                                    <select name="invoice_number" id="invoice_number" class="form-control bg-light @error('invoice_number') is-invalid @enderror">
                                    @forelse ($invoiceDetails as $invoiceDetails)
                                        <option name="invoice_number" value="{{$invoiceDetails->id}}" selected>{{$invoiceDetails->rcmaster->rc_id}}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                    @error('invoice_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_date">Invoice Date *</label>
                                    <input type="date" id="invoice_date" name="invoice_date" class="form-control bg-light @error('invoice_date') is-invalid @enderror" readonly>
                                    @error('invoice_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_id">Customer Name *</label>
                                    <select name="cus_id" id="cus_id" @readonly(true) class="form-control bg-light @error('cus_id') is-invalid @enderror">
                                    </select>
                                    @error('cus_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="part_id">Part Name *</label>
                                    <select name="part_id" id="part_id" @readonly(true) class="form-control bg-light @error('part_id') is-invalid @enderror">
                                    </select>
                                    @error('part_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Total Quantity *</label>
                                    <input type="Number" name="qty" id="qty" class="form-control  bg-light @error('qty') is-invalid @enderror" readonly >
                                    @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="request_reason">REASON *</label>
                                    <textarea name="request_reason" id="request_reason" class="form-control @error('request_reason') is-invalid @enderror" cols="20" rows="3"></textarea>
                                    @error('request_reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center ">
                            <div class="col-md-2 mt-4">
                                <input type="submit" class="btn btn-success  text-white align-center" id="btn" value="Request">
                                <input class="btn btn-danger text-white" id="reset" type="reset" value="Reset">
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}" ></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#invoice_number").select2();
        $("#invoice_number").change(function (e) {
            e.preventDefault();
            var invoice_id=$(this).val();
            // alert(invoice_id);
            $.ajax({
                type: "GET",
                url: "{{route('invoicefetchdata')}}",
                data: {"invoice_id":invoice_id},
                success: function (response) {
                    console.log(response);
                    if (response.invoice_status==1) {
                        $('#cus_id').html(response.cus_id);
                        $('#part_id').html(response.part_id);
                        $('#qty').val(response.invoice_qty);
                        $('#invoice_date').val(response.invoice_date);
                    }else{
                        alert("Sorry This Invoice Number Have Already Request Pending..So Wait For Admin Approval...");
                    }

                }
            });
        });
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $("#pocorrection_formdata").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#pocorrection_formdata")[0]);
            $("#btn").attr('disabled',true);
            $("#btn").val('Updating...');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Add it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                                    // url: editUrl,
                    url: this.action,
                    type:"POST",
                    data: formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                    success: function(data) {
                    if (data.code==404||data.code==500) {
                        let error ='<span class="alert alert-danger">'+data.msg+'</span>';
                            $("#res").html(error);
                                    // $("#btn").attr('disabled',false);
                                    // $("#btn").val('Save');
                    }else{
                        //    console.log(data);
                        $("#btn").attr('disabled',false);
                        $("#btn").val('Save');
                        swalWithBootstrapButtons.fire(
                            'Added!',
                            'PO Correction is Request Submitted Successfully!...',
                            'success'
                            );
                            location.reload(true);
                        }
                    }
                });
                                // ajax request completed
            }else if (
             /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
                ) {
                    $("#btn").attr('disabled',false);
                    $("#btn").val('Save');
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'PO Correction Data is safe',
                    'error'
                    )
                }
            });
        });
        $("#reset").click(function (e) {
            e.preventDefault();
            location.reload(true);
        });
    });
    </script>
    @endsection
