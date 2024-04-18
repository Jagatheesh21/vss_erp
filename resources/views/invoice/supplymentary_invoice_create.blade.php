@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('supplymentaryinvoice.store')}}" id="delivery_challan_formdata" method="POST">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
        <div class="row col-md-3"id="res"></div>
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Create Supplymentary Invoice</b></span><a class="btn btn-sm btn-primary" href="{{route('supplymentaryinvoice')}}">Supplymentary Invoice List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice No. *</label>
                                    <input type="text" name="invoice_number" id="invoice_number" value="{{$new_rcnumber}}" readonly class="form-control bg-light @error('invoice_number') is-invalid @enderror" >
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
                                    <input type="date" name="invoice_date" id="invoice_date" value="{{$current_date}}" readonly class="form-control bg-light @error('invoice_date') is-invalid @enderror" >
                                    @error('invoice_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_id">Customer Code *</label>
                                    <select name="cus_id" id="cus_id" class="form-control @error('cus_id') is-invalid @enderror">
                                    <option value=""></option>
                                    @forelse ($customer_masterdatas as $customer_masterdata)
                                        <option value="{{$customer_masterdata->id}}">{{$customer_masterdata->cus_code}}</option>
                                    @empty
                                    @endforelse
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
                                    <label for="part_id">Part Number *</label>
                                    <select name="part_id" id="part_id" class="form-control part_id  @error('part_id') is-invalid @enderror">
                                        <option value="">Select Partnumber</option>
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
                                    <label for="cus_name">Customer Name *</label>
                                    <input type="text" name="cus_name" id="cus_name" readonly class="form-control  bg-light @error('cus_name') is-invalid @enderror" >
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
                                    <input type="text" name="cus_gst_number"  id="cus_gst_number" readonly minlength="15" maxlength="15" class="form-control  bg-light @error('cus_gst_number') is-invalid @enderror" >
                                    @error('cus_gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_po_id">Customer PO Number *</label>
                                    <select name="cus_po_id" id="cus_po_id" @readonly(true) class="form-control cus_po_id bg-light @error('cus_po_id') is-invalid @enderror">
                                        <option value="">Select Customer PO Number</option>
                                    </select>
                                    @error('cus_po_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="operation_id">Operation *</label>
                                    <select name="operation_id" id="operation_id" @readonly(true) class="form-control operation_id bg-light  @error('operation_id') is-invalid @enderror">
                                        <option value="">Select Operation</option>
                                    </select>
                                    @error('operation_id')
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
                                    <label for="invoice_rate">Invoice Rate*</label>
                                    <input type="number" name="invoice_rate" id="invoice_rate" class="form-control @error('invoice_rate') is-invalid @enderror" >
                                    @error('invoice_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_quantity">Invoice Quantity *</label>
                                    <input type="number" name="invoice_quantity" min="0" id="invoice_quantity" class="form-control @error('invoice_quantity') is-invalid @enderror" >
                                    @error('invoice_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="trans_mode">Mode Of Transaction*</label>
                                    <select name="trans_mode" id="trans_mode" class="form-control @error('trans_mode') is-invalid @enderror">
                                        <option value="BY ROAD" selected>BY ROAD</option>
                                        <option value="BY COURIER">BY COURIER</option>
                                    </select>
                                    @error('trans_mode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="document_type">Document Type *</label>
                                    <select name="document_type" id="document_type" class="form-control @error('document_type') is-invalid @enderror">
                                        <option value="">SELECT THE DOCUMENT TYPE</option>
                                        <option value="SUPPLYMENTARY INVOICE" selected>SUPPLYMENTARY INVOICE</option>
                                    </select>
                                    @error('document_type')
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
                                    <label for="igst_on_intra">IGST ON INTRA*</label>
                                    <select name="igst_on_intra" id="igst_on_intra" class="form-control @error('igst_on_intra') is-invalid @enderror">
                                        <option value="Yes">Yes</option>
                                        <option value="No" selected>No</option>
                                    </select>
                                    @error('igst_on_intra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reverse_charge">REVERSE CHARGE*</label>
                                    <select name="reverse_charge" id="reverse_charge" class="form-control @error('reverse_charge') is-invalid @enderror">
                                        <option value="Yes">Yes</option>
                                        <option value="No" selected>No</option>
                                    </select>
                                    @error('reverse_charge')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vehicle_no">VEHICLE NO *</label>
                                    <input type="text" name="vehicle_no"  id="vehicle_no" pattern="^[A-Z]{2}-\d{2}-[A-Z]{1}.-\d{4}$" onkeyup="format()" placeholder="TN-99-AA-1111 (OR) TN-99-A--1111" class="form-control @error('vehicle_no') is-invalid @enderror" >
                                    @error('vehicle_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks">REMARKS *</label>
                                    <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" cols="20" rows="3"></textarea>
                                    @error('remarks')
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
                                    <button class="btn btn-primary mt-4" id="proceed">Proceed Invoice</button>
                                </div>
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
        $("#cus_id").select2();
        $("#part_id").select2();
        $("#trans_mode").select2();
        $('#proceed').hide();
        $('#invoice_quantity').attr('readonly',true);
        $('#invoice_quantity').addClass('bg-light');
        $('#cus_id').change(function (e) {
            e.preventDefault();
            var cus_id=$(this).val();
            // alert(cus_id);
            $.ajax({
                type: "GET",
                url: "{{route('cuspartdata')}}",
                data: {"cus_id":cus_id},
                success: function (response) {
                    console.log(response);
                    $('#invoice_quantity').attr('readonly',true);
                    $('#table_logic').html('<tr><td colspan="6" class="text-center">No Record Found</td></tr>');
                    $('#proceed').hide();
                    if(response.count > 0){
                    $('#part_id').html(response.part_id);
                    $('#cus_name').val(response.cus_name);
                    $('#cus_gst_number').val(response.cus_gst_number);
                    }else{
                        alert('Please Choose Customer...');
                    }
                }
            });
            $('#part_id').change(function (e) {
                e.preventDefault();
                var cus_id=$("#cus_id").val();
                var part_id=$(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('supplymentaryinvoiceitempo')}}",
                    data: {"cus_id":cus_id,"part_id":part_id},
                    success: function (response) {
                        // console.log(response);
                        $('#cus_po_id').html(response.cus_po_no);
                        $('#operation_id').html(response.operation);
                        $('#invoice_quantity'). attr('max',response.t_avl_qty);
                        $('#invoice_quantity').attr('readonly',false);
                        $('#invoice_quantity').removeClass('bg-light');
                        $('#proceed').hide();
                    }
                });
            });
        });
        // vehicle number format
        function format() {
            var x=$('#vehicle_no').val();
			x.value=x.value.toUpperCase();
			if(event.keyCode!=8)
			{
				if(x.value.toString().length==2)
				{
					x.value=x.value+'-';
				}
				if(x.value.toString().length==5)
				{
					x.value=x.value+'-';
				}
				if(x.value.toString().length==8)
				{
					x.value=x.value+'-';
				}
			}
		}
        $("#invoice_quantity").change(function(){
            var invoice_quantity = $(this).val();
            if (invoice_quantity!='') {
                $('#proceed').show();
            }else{
                $('#proceed').hide();
                return false;
            }
        });
    </script>
@endpush
