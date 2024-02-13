@extends('layouts.app')
@push('styles')
    
@endpush
@section('content')
<form action="{{route('po.store')}}" id="po_formdata" method="POST">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
    <div class="col-12">
        <div class="row col-md-3"id="res"></div>

        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Create Purchase Order</b></span><a class="btn btn-sm btn-primary" href="{{route('po.index')}}">Purchase Order List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ponumber">PO Number *</label>
                                    <input type="text" name="ponumber" id="ponumber" value="{{$new_ponumber}}" readonly class="form-control bg-light @error('ponumber') is-invalid @enderror" >
                                    @error('ponumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="podate">PO Date *</label>
                                    <input type="date" name="podate" id="podate" value="{{$current_date}}" readonly class="form-control bg-light @error('podate') is-invalid @enderror" >
                                    @error('podate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Code *</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                    <option value=""></option>
                                    @forelse ($suppliers as $code)
                                        <option value="{{$code->id}}">{{$code->supplier_code}}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                    @error('supplier_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Name *</label>
                                    <input type="text" name="name" id="name" readonly class="form-control bg-light @error('name') is-invalid @enderror" >
                                    @error('name')
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
                                    <label for="contact_person">Contact Person*</label>
                                    <input type="text" name="contact_person" id="contact_person"  readonly class="form-control bg-light @error('contact_person') is-invalid @enderror" >
                                    @error('contact_person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Contact No*</label>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" >
                                    @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">GST Number *</label>
                                    <input type="text" name="gst_number" maxlength="15" minlength="15" id="gst_number" class="form-control @error('gst_number') is-invalid @enderror" >
                                    @error('gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Address *</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" id="" cols="20" rows="3"></textarea>
                                    @error('address')
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
                                    <label for="trans_mode">Mode Of Transaction*</label>
                                    <select name="trans_mode" id="trans_mode" class="form-control @error('trans_mode') is-invalid @enderror">
                                        <option value="BY ROAD">BY ROAD</option>
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
                                    <label for="cgst">CGST (%) *</label>
                                    <input type="number" name="cgst" id="cgst" class="form-control @error('cgst') is-invalid @enderror" >
                                    @error('cgst')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sgst">SGST (%) *</label>
                                    <input type="number" name="sgst" id="sgst" min="0" class="form-control @error('sgst') is-invalid @enderror" >
                                    @error('sgst')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="igst">IGST (%) *</label>
                                    <input type="number" name="igst" id="igst" class="form-control @error('igst') is-invalid @enderror" >
                                    @error('igst')
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
                                    <label for="packing_charges">Packing Charge (%) *</label>
                                    <input type="number" name="packing_charges" id="packing_charges" class="form-control @error('packing_charges') is-invalid @enderror" >
                                    @error('packing_charges')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="currency_id">Mode Of Currency*</label>
                                    <select name="currency_id" id="currency_id" class="form-control @error('currency_id') is-invalid @enderror">
                                        <option value="0">INR</option>
                                        <option value="1">USD</option>
                                    </select>
                                    @error('currency_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="purchasetype">Purchase Type *</label>
                                    <input type="text" name="purchasetype" id="purchasetype" class="form-control @error('purchasetype') is-invalid @enderror" >
                                    @error('purchasetype')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="payment_terms">Payment Terms *</label>
                                    <input type="text" name="payment_terms" id="payment_terms" class="form-control @error('payment_terms') is-invalid @enderror" >
                                    @error('payment_terms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="indentno">Indent No *</label>
                                    <input type="text" name="indentno" id="indentno" class="form-control @error('indentno') is-invalid @enderror" >
                                    @error('indentno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="indentdate">Indent Date *</label>
                                    <input type="date" name="indentdate" id="indentdate" class="form-control @error('indentdate') is-invalid @enderror" >
                                    @error('indentdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quotno">Quote No *</label>
                                    <input type="text" name="quotno" id="quotno" class="form-control @error('quotno') is-invalid @enderror" >
                                    @error('quotno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quotdt">Quote Date *</label>
                                    <input type="date" name="quotdt" id="quotdt" class="form-control @error('quotdt') is-invalid @enderror" >
                                    @error('quotdt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks1">Remarks 1 *</label>
                                    <textarea name="remarks1" id="remarks1" class="form-control @error('remarks1') is-invalid @enderror" id="" cols="20" rows="3"></textarea>
                                    @error('remarks1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks2">Remarks 2 *</label>
                                    <textarea name="remarks2" id="remarks2" class="form-control @error('remarks2') is-invalid @enderror" id="" cols="20" rows="3"></textarea>
                                    @error('remarks2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks3">Remarks 3 *</label>
                                    <textarea name="remarks3" id="remarks3" class="form-control @error('remarks3') is-invalid @enderror" id="" cols="20" rows="3"></textarea>
                                    @error('remarks3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remarks4">Remarks 4 *</label>
                                    <textarea name="remarks4" id="remarks4" class="form-control @error('remarks4') is-invalid @enderror" id="" cols="20" rows="3"></textarea>
                                    @error('remarks4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix mt-3">
                        <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive" id="tab_logic">
                                <thead>
                                <tr>
                                    <th>Material Category</th>
                                    <th>Material Description</th>
                                    <th>Material HSN Code</th>
                                    <th>Due Date</th>
                                    <th>UOM</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Total Cost</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><select name="raw_material_category_id[]"  class="form-control raw_material_category_id"></select></td>
                                    <td><select name="supplier_product_id[]" id="" class="form-control supplier_product_id"></select></td>
                                    <td><input type="text" class="form-control products_hsnc"  name="products_hsnc[]"></td>
                                    <td><input type="date" class="form-control duedate" id="duedate" name="duedate[]"></td>
                                    <td><select name="uom_id[]"  class="form-control bg-white uom_id"></td>
                                    <td><input type="number"  class="form-control products_rate" name="products_rate[]" readonly></td>
                                    <td><input type="text"  class="form-control qty" name="qty[]" value="1"></td>
                                    <td><input type="number" class="form-control rate" name="rate[]" readonly></td>
                                    <td>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    <div class="row mb-3 clearfix">
                        <div class="col-md-12 ">
                          <button id="add_row" type="button" class="btn btn-sm btn-primary float-end text-white">Add Row</button>
                          <!-- <button id='delete_row' type="button" class="float-end btn btn-danger text-white" onclick="confirm('Are you Sure, Want to Delete the Row?')">Delete Row</button> -->
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3 d-flex justify-content-end clearfix">
                        <div class="col-2"><h6>Grand Total:</h6></div>
                        <div class="col-2"><input type="text" name="grand_total" class="form-control" id="grand_total" readonly></div>
                        <!-- <div class="col-md-12">
                            <div class="col-md-10">Total</div>
                            <div class="col-md-2"></div>
                        </div> -->
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
<!-- <script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script> -->
@push('scripts')
<script>
$(document).ready(function(){
    $('input').on('input', function() {
        var inputId = $(this).attr('id');
        $('#' + inputId + '-error').remove();
    });
    
});
    $("#supplier_id").select2({
        placeholder:"Select Supplier",
        allowedClear:true
    });
    
    $(".raw_material_category_id").select2({
        placeholder:"Select Material Category",
        allowedClear:true
    });
    $(".supplier_product_id").select2({
        placeholder:"Select Material",
        allowedClear:true
    });
    
    $("#supplier_id").change(function(e){
        e.preventDefault();
        var supplier_id=$(this).val();
        $.ajax({
            url: "{{ route('posuppliersdata') }}?id=" + $(this).val(),
            method: 'GET',
            cache:false,
            processData:false,
            contentType:false,
            success : function(result){
                // console.log(result);
                $("#supplier_id").select2();
                $("#raw_material_category_id").select2();
                if (result.count > 0) {
                    $('#name').val(result.name);
                    $('#name'). attr('readonly','true');
                    $('#contact_person').val(result.contact_person);
                    $('#contact_number').val(result.contact_number);
                    $('#gst_number').val(result.gst_number);
                    $('#address').val(result.address);
                    $('#trans_mode').html(result.trans_mode);
                    $('#cgst').val(result.cgst);
                    $('#sgst').val(result.sgst);
                    $('#igst').val(result.igst);
                    $('#packing_charges').val(result.packing_charges);
                    $('#currency_id').html(result.currency_id);
                    $('#remarks').val(result.remarks);
                    $('.raw_material_category_id').html(result.category);

                }else{
                    // location.reload(true);
                    // $('#supplier_code').val('abc');
                    $('#name').val('');
                    $('#contact_number').val('');
                    $('#gst_number').val('');
                    $('#address').val('');
                    $('#trans_mode').html(result.trans_mode);
                    $('#cgst').val('');
                    $('#sgst').val('');
                    $('#igst').val('');
                    $('#packing_charges').val('');
                    $('#currency_id').html(result.currency_id);
                    $('#remarks').val('');
                    $("#submit_btn").attr('disabled',false);

                }
            }
        });
	});
    function get_material(){
        var closestTr = $(this).closest('tr');
        $(".raw_material_category_id").select2();
        var supplier_id=$("#supplier_id").val();
        var raw_material_category_id=$(this).val();
        $.ajax({
            url: "{{ route('posuppliersrmdata') }}",
            method: 'POST',
            data:{
                "_token": "{{ csrf_token() }}",
                "raw_material_category_id":raw_material_category_id,
                "supplier_id":supplier_id
            },
            success : function(result){
                $(".raw_material_category_id").select2();
                closestTr.find('.supplier_product_id').html(result);
            }
        });
        
    }
    $(".raw_material_category_id").change(function(e){
        e.preventDefault();
        var closestTr = $(this).closest('tr');
        $(".raw_material_category_id").select2();
        var supplier_id=$("#supplier_id").val();
        var raw_material_category_id=$(this).val();
        $.ajax({
            url: "{{ route('posuppliersrmdata') }}",
            method: 'POST',
            data:{
                "_token": "{{ csrf_token() }}",
                "raw_material_category_id":raw_material_category_id,
                "supplier_id":supplier_id
            },
            success : function(result){
                $(".raw_material_category_id").select2();
                closestTr.find('.supplier_product_id').html(result);
                
            }
        });
	});
    $(".supplier_product_id").change(function(e){
        e.preventDefault();
        var supplier_id=$("#supplier_id").val();
        var closestTr = $(this).closest('tr');
        var raw_material_category_id=closestTr.find(".raw_material_category_id").val();
        var supplier_product_id=$(this).val();
        $("#supplier_product_id").select2();
        $.ajax({
            url: "{{ route('posuppliersproductdata') }}",
            method: 'POST',
            data:{
                "_token": "{{ csrf_token() }}",
                "raw_material_category_id":raw_material_category_id,
                "supplier_id":supplier_id,
                "supplier_product_id":supplier_product_id,
            },
            success : function(result){
                $(".supplier_product_id").select2();
                closestTr.find(".uom_id").html(result.html);
                closestTr.find(".products_hsnc").val(result.products_hsnc);
                closestTr.find(".products_rate").val(result.products_rate);
                calculate();
            }
        });
	});
    $('.qty').change(function (e) {
        e.preventDefault();
        var closestTr = $(this).closest('tr');
        var products_rate=closestTr.find(".products_rate").val();
        var qty=$(this).val();
        if(products_rate!=''&&qty!=''){
            var total_cost=products_rate * qty;
            closestTr.find(".rate").val(total_cost);
        }
        calculate();
    });
    $('.products_rate').change(function (e) {
        e.preventDefault();
        var products_rate=$(this).val();
        var closestTr = $(this).closest('tr');
        var qty=closestTr.find(".qty").val();
        if(products_rate!=''&&qty!=''){
            var total_cost=products_rate * qty;
            closestTr.find(".rate").val(total_cost);
        }
    });

    // Add Dynamic Rows
    $("#add_row").click(function(){
        var supplier_id = $("#supplier_id").val();
        if(supplier_id==""){
            alert("Please select supplier!");
            return false;
        }
        $.ajax({
            url:"{{route('add_purchase_item')}}",
            type:"POST",
            data:{"supplier_id":supplier_id},
            success:function(response){ 

                $("#tab_logic").append(response.category);
                $(".raw_material_category_id").select2({
                    placeholder:"Select Material Category",
                    allowedClear:true
                });
                $(".supplier_product_id").select2({
                    placeholder:"Select Material",
                    allowedClear:true
                });
            }
        });
    });

    var i=1;
    // $("#add_row").click(function(){b=i-1;
    //   	$('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
    //   	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
    //   	i++;
  	// });
    //   $("#delete_row").click(function(){
    // 	if(i>1){
	// 	$("#addr"+(i-1)).html('');
	// 	i--;
	// 	}
	// });
    $("#po_formdata").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($("#po_formdata")[0]);
        $('#po_formdata').find(':input').removeClass('text-danger');
        // Updated code
        $.ajax({
                                // url: editUrl,
                url: this.action,
                type:"POST",
                data: formData,
                dataType:"json",
                cache:false,
                processData:false,
                contentType:false,
                success: function(data) {
                    // Clear previous errors
                    toastr.success("Success", "Purchase order created successfully!");
                    location.reload(true);
                // console.log(data.responseJSON);
                // if (data.code==404||data.code==500 || data.code==422) {
                //     let error ='<span class="alert alert-danger">'+data.msg+'</span>';
                //         $("#res").html(error);
                //                 // $("#btn").attr('disabled',false);
                //                 // $("#btn").val('Save');
                // }else{
                //     //    console.log(data);
                //     $("#btn").attr('disabled',false);
                //     $("#btn").val('Save');
                //     swalWithBootstrapButtons.fire(
                //         'Added!',
                //         'Purchase Order is Created Successfully!...',
                //         'success'
                //         );
                //         location.reload(true);
                //     }
                },error: function(xhr) {
                    $('#po_formdata :input').each(function() {
            formData[$(this).attr('name')] = $(this).val();
            console.log($(this).attr('name'));
        });
                // Handle validation errors
                if (xhr.status == 422) {
                    $('.error').remove();
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        // Display error next to input field
                        // console.log(key);
                        // console.log(value[0]);
                        if ($('#' + key).length && !$('#' + key + '-error').length) {
                            $('#' + key).closest('.form-control').addClass('is-invalid');
                            $('#' + key).after('<div class="text-danger" id="' + key + '-error">' + value[0] + '</div>');
                        }
                       
                    });
                }
            }
    //         $('input').on('input', function() {
    //     var inputId = $(this).attr('id');
    //     $('#' + inputId + '-error').remove();
    // });
            });
            
            
        // updated code


        // $("#btn").attr('disabled',true);
        // $("#btn").val('Updating...');
        // const swalWithBootstrapButtons = Swal.mixin({
        //     customClass: {
        //             confirmButton: 'btn btn-success mr-5',
        //             cancelButton: 'btn btn-danger'
        //         },
        //     buttonsStyling: false
        // });

        // swalWithBootstrapButtons.fire({
        // title: 'Are you sure?',
        // text: "You won't be able to revert this!",
        // icon: 'warning',
        // showCancelButton: true,
        // confirmButtonText: 'Yes, Update it!',
        // cancelButtonText: 'No, cancel!',
        // reverseButtons: true
        // }).then((result) => {
        // if (result.isConfirmed) {
        //     $.ajax({
        //                         // url: editUrl,
        //         url: this.action,
        //         type:"POST",
        //         data: formData,
        //         cache:false,
        //         processData:false,
        //         contentType:false,
        //         success: function(data) {
        //         if (data.code==404||data.code==500 || data.code==422) {
        //             let error ='<span class="alert alert-danger">'+data.msg+'</span>';
        //                 $("#res").html(error);
        //                         // $("#btn").attr('disabled',false);
        //                         // $("#btn").val('Save');
        //         }else{
        //             //    console.log(data);
        //             $("#btn").attr('disabled',false);
        //             $("#btn").val('Save');
        //             swalWithBootstrapButtons.fire(
        //                 'Added!',
        //                 'Purchase Order is Created Successfully!...',
        //                 'success'
        //                 );
        //                 location.reload(true);
        //             }
        //         }
        //     });
        //                     // ajax request completed
        // }else if (
        //  /* Read more about handling dismissals below */
        //     result.dismiss === Swal.DismissReason.cancel
        //     ) {
        //         $("#btn").attr('disabled',false);
        //         $("#btn").val('Save');
        //         swalWithBootstrapButtons.fire(
        //         'Cancelled',
        //         'Your Purchase Order Datas is safe',
        //         'error'
        //         )
        //     }
        // });
    });
    $("#reset").click(function (e) {
        e.preventDefault();
        location.reload(true);
    });

    function calculate()
    {
        var grand_total = 0;
        $('table > tbody  > tr').each(function(index, row) { 
            var rate = $(row).find('.products_rate').val();
            var qty = $(row).find('.qty').val();
            var total = rate * qty;
            $(row).find('.rate').val(total);
            grand_total+=total;
            $("#grand_total").val(grand_total);
        });
    }
</script>
@endpush

