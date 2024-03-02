@extends('layouts.app')
@section('content')

<form action="{{route('customer.store')}}" id="supplier_formdata" method="POST">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
    <div class="col-12">
        <div class="row col-md-3"id="res"></div>
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Create Customer</b></span><a class="btn btn-sm btn-primary" href="{{route('customer.index')}}">Customer List</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cus_code">Code *</label>
                            <input type="text" name="cus_code" id="cus_code" class="form-control @error('cus_code') is-invalid @enderror" >
                            @error('cus_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="supplier_vendor_code">Supplier Vendor Code *</label>
                            <input type="text" name="supplier_vendor_code"  id="supplier_vendor_code" class="form-control @error('supplier_vendor_code') is-invalid @enderror" >
                            @error('supplier_vendor_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="supplytype">Supply Type *</label>
                            <input type="text" name="supplytype"  id="supplytype" class="form-control @error('supplytype') is-invalid @enderror" >
                            @error('supplytype')
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
                                    <label for="cus_name">Customer Name *</label>
                                    <input type="text" name="cus_name" id="cus_name" class="form-control @error('cus_name') is-invalid @enderror" >
                                    @error('cus_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_gst_number">Customer GST Number *</label>
                                    <input type="text" name="cus_gst_number" maxlength="15" minlength="15" id="cus_gst_number" class="form-control @error('cus_gst_number') is-invalid @enderror" >
                                    @error('cus_gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_address">Customer Address *</label>
                                    <input type="text" name="cus_address" id="cus_address" class="form-control @error('cus_address') is-invalid @enderror" >
                                    @error('cus_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_address1">Customer Address1 *</label>
                                    <input type="text" name="cus_address1" id="cus_address1" class="form-control @error('cus_address1') is-invalid @enderror" >
                                    @error('cus_address1')
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
                                    <label for="cus_city">Customer City *</label>
                                    <input type="text" name="cus_city"  id="cus_city" class="form-control @error('cus_city') is-invalid @enderror" >
                                    @error('cus_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_state">Customer State *</label>
                                    <input type="text" name="cus_state"  id="cus_state" class="form-control @error('cus_state') is-invalid @enderror" >
                                    @error('cus_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_country">Customer Country *</label>
                                    <input type="text" name="cus_country"  id="cus_country" class="form-control @error('cus_country') is-invalid @enderror" >
                                    @error('cus_country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_pincode">Customer Pincode *</label>
                                    <input type="text" name="cus_pincode"  id="cus_pincode" class="form-control @error('cus_pincode') is-invalid @enderror" >
                                    @error('cus_pincode')
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
                                    <label for="delivery_cus_name">Delivery Customer Name *</label>
                                    <input type="text" name="delivery_cus_name" id="delivery_cus_name" class="form-control @error('delivery_cus_name') is-invalid @enderror" >
                                    @error('delivery_cus_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="delivery_cus_gst_number">Delivery Customer GST Number *</label>
                                    <input type="text" name="delivery_cus_gst_number" maxlength="15" minlength="15" id="delivery_cus_gst_number" class="form-control @error('delivery_cus_gst_number') is-invalid @enderror" >
                                    @error('delivery_cus_gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="delivery_cus_address">Delivery Customer Address *</label>
                                    <input type="text" name="delivery_cus_address" id="delivery_cus_address" class="form-control @error('delivery_cus_address') is-invalid @enderror" >
                                    @error('delivery_cus_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="delivery_cus_address1">Delivery Customer Address1 *</label>
                                    <input type="text" name="delivery_cus_address1" id="delivery_cus_address1" class="form-control @error('delivery_cus_address1') is-invalid @enderror" >
                                    @error('delivery_cus_address1')
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
                                    <label for="delivery_cus_city">Delivery Customer City *</label>
                                    <input type="text" name="delivery_cus_city"  id="delivery_cus_city" class="form-control @error('delivery_cus_city') is-invalid @enderror" >
                                    @error('delivery_cus_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="delivery_cus_state">Delivery Customer State *</label>
                                    <input type="text" name="delivery_cus_state"  id="delivery_cus_state" class="form-control @error('delivery_cus_state') is-invalid @enderror" >
                                    @error('delivery_cus_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="delivery_cus_country">Delivery Customer Country *</label>
                                    <input type="text" name="delivery_cus_country"  id="delivery_cus_country" class="form-control @error('delivery_cus_country') is-invalid @enderror" >
                                    @error('delivery_cus_country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="delivery_cus_pincode">Delivery Customer Pincode *</label>
                                    <input type="text" name="delivery_cus_pincode"  id="delivery_cus_pincode" class="form-control @error('delivery_cus_pincode') is-invalid @enderror" >
                                    @error('delivery_cus_pincode')
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


<script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}" ></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
$(document).ready(function(){


    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $("#cus_code").change(function(e){
        e.preventDefault();
        var customer_code=$(this).val();
        $.ajax({
            url: "{{ route('customersdata') }}?id=" + $(this).val(),
            method: 'GET',
            cache:false,
            processData:false,
            contentType:false,
            success : function(result){
                console.log(result);
                if (result.count > 0) {
                    $('#cus_name').val(result.cus_name);
                    $('#cus_gst_number').val(result.cus_gst_number);
                    $('#cus_address').val(result.cus_address);
                    $('#cus_address1').val(result.cus_address1);
                    $('#cus_city').html(result.cus_city);
                    $('#cus_state').val(result.cus_state);
                    $('#cus_country').val(result.cus_country);
                    $('#cus_pincode').val(result.cus_pincode);
                    $('#delivery_cus_name').val(result.delivery_cus_name);
                    $('#delivery_cus_gst_number').val(result.delivery_cus_gst_number);
                    $('#delivery_cus_address').val(result.delivery_cus_address);
                    $('#delivery_cus_address1').val(result.delivery_cus_address1);
                    $('#delivery_cus_city').val(result.delivery_cus_city);
                    $('#delivery_cus_state').val(result.delivery_cus_state);
                    $('#delivery_cus_country').val(result.delivery_cus_country);
                    $('#delivery_cus_pincode').val(result.delivery_cus_pincode);
                    $('#supplier_vendor_code').val(result.supplier_vendor_code);
                    $('#supplytype').val(result.supplytype);
                    $("#submit_btn").attr('disabled',true);
                    $("#submit_btn").val('Save');
                    alert('This Customer Code Already Exist!!!')
                    setTimeout(() => {
                        location.reload(true);
                    }, 3000);
                }else{
                    // location.reload(true);
                    // $('#customer_code').val('abc');
                    $('#cus_name').val('');
                    $('#cus_gst_number').val('');
                    $('#cus_address').val('');
                    $('#cus_address1').val('');
                    $("#cus_city").val('');
                    $('#cus_state').val('');
                    $('#cus_country').val('');
                    $('#cus_pincode').val('');
                    $('#delivery_cus_name').val('');
                    $('#delivery_cus_gst_number').val('');
                    $('#delivery_cus_address').html(result.currency_id);
                    $('#delivery_cus_address1').val('');
                    $('#delivery_cus_city').val('');
                    $('#delivery_cus_state').val('');
                    $('#delivery_cus_country').val('');
                    $('#delivery_cus_pincode').val('');
                    $('#supplier_vendor_code').val('');
                    $('#supplytype').val('');
                    $("#submit_btn").attr('disabled',false);

                }
            }
        });
	});
    $("#supplier_formdata").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($("#supplier_formdata")[0]);
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
                        'Supplier is Created Successfully!...',
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
                'Your Supplier Datas is safe',
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
