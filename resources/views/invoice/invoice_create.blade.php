@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('invoicedetails.store')}}" id="delivery_challan_formdata" method="POST">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
        <div class="row col-md-3"id="res"></div>
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Create Invoice</b></span><a class="btn btn-sm btn-primary" href="{{route('invoicedetails.index')}}">Invoice List</a>
            </div>
            <div class="card-body">
                    <div class="row d-flex justify-content-center">
                    <span class="me-auto mb-3"><button class="btn btn-primary">STEP 1-Customer Details</button></span>
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
                                    <label for="cus_order_qty">Order Quantity *</label>
                                    <input type="number" name="cus_order_qty" readonly id="cus_order_qty" class="form-control bg-light @error('cus_order_qty') is-invalid @enderror" >
                                    @error('cus_order_qty')
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="avl_quantity">Available Quantity*</label>
                                    <input type="number" name="avl_quantity" id="avl_quantity" @readonly(true) class="form-control bg-light @error('avl_quantity') is-invalid @enderror" >
                                    @error('avl_quantity')
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
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="document_type">Document Type *</label>
                                    <select name="document_type" id="document_type" class="form-control @error('document_type') is-invalid @enderror">
                                        <option value="">SELECT THE DOCUMENT TYPE</option>
                                        <option value="TAX INVOICE" selected>TAX INVOICE</option>
                                    </select>
                                    @error('document_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
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
                        </div>
                        <div class="row d-flex">
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
                                    <label for="issue_wt">ISSUE WEIGHT *</label>
                                    <input type="number" name="issue_wt" @readonly(true)  id="issue_wt" min="0" class="form-control bg-light @error('issue_wt') is-invalid @enderror" >
                                    @error('issue_wt')
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
                            <input type="hidden" name="traceable_count" class="form-control traceable_count" id="traceable_count" >
                            <input type="hidden" name="regular" class="form-control regular" id="regular" >
                            <input type="hidden" name="alter" class="form-control alter" id="alter">
                            <input type="hidden" name="bom" class="form-control bom" id="bom">
                        </div>
                        <div class="row clearfix mt-3" id="step2">
                        <span class="me-auto mb-3"><button class="btn btn-info text-white">STEP 2-Customer PO Rate Details</button></span>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th><b>PART NUMBER</b></th>
                                            <th><b>HSN CODE</b></th>
                                            <th><b>RATE</b></th>
                                            <th><b>PACKING CHARGES(%)</b></th>
                                            <th><b>CGST(%)</b></th>
                                            <th><b>SGST(%)</b></th>
                                            <th><b>IGST(%)</b></th>
                                            <th><b>TCS (%)</b></th>
                                            <th><b>PACKING CHARGES AMOUNT</b></th>
                                            <th><b>CGST AMOUNT</b></th>
                                            <th><b>SGST AMOUNT</b></th>
                                            <th><b>IGST AMOUNT</b></th>
                                            <th><b>TCS  AMOUNT</b></th>
                                            <th><b>BASIC  VALUE</b></th>
                                            <th><b>TOTAL  VALUE</b></th>
                                        </tr>
                                        </thead>
                                        <tbody  id="table_logic1">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix mt-3"  id="step3">
                            <span class="me-auto mb-3"><button class="btn btn-secondary text-white">STEP 3-Rote Card Details</button></span>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th><b>Part No</b></th>
                                            <th><b>Order</b></th>
                                            <th><b>Route Card</b></th>
                                            <th><b>Route Card Available Quantity</b></th>
                                            <th><b>Invoice Quantity</b></th>
                                            <th><b>Balance</b></th>
                                        </tr>
                                        </thead>
                                        <tbody  id="table_logic2">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button class="btn btn-success text-white mt-4" id="proceed">Proceed Invoice</button>
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
        $('#step2').hide();
        $('#step3').hide();
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
                    $('#table_logic2').html('<tr><td colspan="6" class="text-center">No Record Found</td></tr>');
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
        });

        $('#part_id').change(function (e) {
                e.preventDefault();
                var cus_id=$("#cus_id").val();
                var part_id=$(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('invoiceitemrc')}}",
                    data: {"cus_id":cus_id,"part_id":part_id},
                    success: function (response) {
                        // console.log(response);
                        if (response.success) {
                            if (response.message) {
                                $('#cus_po_id').html(response.cus_po_no);
                                // $('#cus_order_qty').val(response.t_avl_qty);
                                $('#cus_order_qty').val(1000);
                                $('#avl_quantity').val(response.t_avl_qty);
                                $('#operation_id').html(response.operation);
                                $('#invoice_quantity'). attr('max',response.t_avl_qty);
                                $('#invoice_quantity').attr('readonly',false);
                                $('#invoice_quantity').removeClass('bg-light');
                                $('#table_logic1').html(response.table1);
                                $('#table_logic2').html(response.table2);
                                $('#traceable_count').val(response.traceable_count);
                                $('#regular').val(response.regular);
                                $('#alter').val(response.alter);
                                $('#bom').val(response.bom);
                                $('#proceed').hide();
                                $('#step2').show();
                                $('#step3').show();
                            }else{
                                $('#cus_po_id').html(response.cus_po_no);
                                // $('#cus_order_qty').val(response.t_avl_qty);
                                $('#cus_order_qty').val(1000);
                                $('#avl_quantity').val(response.t_avl_qty);
                                $('#operation_id').html(response.operation);
                                $('#invoice_quantity'). attr('max',response.t_avl_qty);
                                $('#invoice_quantity').attr('readonly',false);
                                $('#invoice_quantity').removeClass('bg-light');
                                $('#table_logic1').html(response.table1);
                                $('#table_logic2').html(response.table2);
                                $('#traceable_count').val(response.traceable_count);
                                $('#regular').val(response.regular);
                                $('#alter').val(response.alter);
                                $('#bom').val(response.bom);
                                var msg='Sorry Something else in Pickup Part Number.So Contact to ERP Team...';
                                alert(msg);
                                location.reload(true);
                            }
                        } else {
                            $('#cus_po_id').html(response.cus_po_no);
                        // $('#cus_order_qty').val(response.t_avl_qty);
                            $('#cus_order_qty').val(1000);
                            $('#avl_quantity').val(response.t_avl_qty);
                            $('#operation_id').html(response.operation);
                            $('#invoice_quantity'). attr('max',response.t_avl_qty);
                            $('#invoice_quantity').attr('readonly',false);
                            $('#invoice_quantity').removeClass('bg-light');
                            $('#table_logic1').html(response.table1);
                            $('#table_logic2').html(response.table2);
                            $('#traceable_count').val(response.traceable_count);
                            $('#regular').val(response.regular);
                            $('#alter').val(response.alter);
                            $('#bom').val(response.bom);
                            $('#proceed').hide();
                            $('#step2').show();
                            $('#step3').show();
                        }
                    }
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
            var invoice_avl_qty = $('#avl_quantity').val();
            var invoice_order_qty = $('#cus_order_qty').val();
            var regular=$('#regular').val();
            var alter=$('#alter').val();
            var bom=$('#bom').val();
            var issue_wt=invoice_quantity*bom;
            var part_rate=$('.part_rate').val();
            var basic_value=part_rate*invoice_quantity;
            var cgst=$('.cgst').val();
            var sgst=$('.sgst').val();
            var igst=$('.igst').val();
            var packing_charges=$('.packing_charges').val();
            var packing_charges_amt=((basic_value)*((packing_charges)*(0.01)));
            var cgst_amt=(basic_value)*((cgst)*(0.01));
            var sgst_amt=(basic_value)*((sgst)*(0.01));
            var igst_amt=(basic_value)*((igst)*(0.01));
            var total_amt=(basic_value+packing_charges_amt+cgst_amt+sgst_amt+igst_amt);
            $('.basic_value').val(basic_value.toFixed(2));
            $('.tcs').val(0);
            $('.packing_charges_amt').val(packing_charges_amt.toFixed(2));
            $('.cgst_amt').val(cgst_amt.toFixed(2));
            $('.sgst_amt').val(sgst_amt.toFixed(2));
            $('.igst_amt').val(igst_amt.toFixed(2));
            $('.total_value').val(total_amt.toFixed(2));
            // alert(issue_wt);
            $('#issue_wt').val(issue_wt);
            var diff=invoice_avl_qty-invoice_quantity;
            var diff2=invoice_order_qty-invoice_quantity;
            // alert(regular);
            if (regular==1) {
                // if (invoice_avl_qty>=invoice_quantity) {
                    if (diff2>=0) {
                        if (diff>=0) {
                            var total = invoice_quantity;
                            $('table > tbody  > tr').each(function(index, row) {
                            $(row).find('.issue_quantity').val('');
                            var qty = $(row).find('.available_quantity').val();
                            if(total>=qty && total>0){
                                total-=qty;
                                $(row).find('.issue_quantity').val(qty);
                                console.log('method 1');
                            }else if(qty>total){
                            $(row).find('.issue_quantity').val(total);
                                total = 0;
                            }
                            var balance = qty-($(row).find('.issue_quantity').val());
                            $(row).find('.balance').val(balance);
                            });
                            $('#proceed').show();
                        }else{
                            $('#proceed').hide();
                            alert('Sorry This Quantity More Than Available Quantity..');
                            return false;
                        }
                    } else {
                        $('#proceed').hide();
                        alert('Sorry This Quantity More Than Order Quantity..');
                        return false;
                    }

            }if (alter==1) {
                if (diff2>=0) {
                        if (diff>=0) {
                            var total = invoice_quantity;
                            $('table > tbody  > tr').each(function(index, row) {
                            $(row).find('.issue_quantity').val('');
                            var qty = $(row).find('.available_quantity').val();
                            if(total>=qty && total>0){
                                total-=qty;
                                $(row).find('.issue_quantity').val(qty);
                                console.log('method 1');
                            }else if(qty>total){
                            $(row).find('.issue_quantity').val(total);
                                total = 0;
                            }
                            var balance = qty-($(row).find('.issue_quantity').val());
                            $(row).find('.balance').val(balance);
                            });
                            $('#proceed').show();
                        }else{
                            $('#proceed').hide();
                            alert('Sorry This Quantity More Than Available Quantity..');
                            return false;
                        }
                    } else {
                        $('#proceed').hide();
                        alert('Sorry This Quantity More Than Order Quantity..');
                        return false;
                    }
            }
            else {
                let i;
                let x=$('table > tbody  > tr').toArray();
                for (i= 0; i < x.length; i++) {
                    // alert(x[i].innerHTML);
                }
                $('#proceed').show();

            }

        });
    </script>
@endpush
