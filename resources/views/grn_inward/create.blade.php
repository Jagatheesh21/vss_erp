@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('grn_inward.store')}}" id="grn_inward_formdata" method="POST">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
    <div class="col-12">
        <div class="row col-md-3"id="res"></div>

        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Create GRN</b></span><a class="btn btn-sm btn-primary" href="{{route('grn_inward.index')}}">GRN List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="grnnumber">GRN Number *</label>
                                    <input type="text" name="grnnumber" id="grnnumber" value="{{$new_grnnumber}}" readonly class="form-control bg-light @error('grnnumber') is-invalid @enderror" >
                                    @error('grnnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="grndate">GRN Date *</label>
                                    <input type="date" name="grndate" id="grndate" value="{{$current_date}}" readonly class="form-control bg-light @error('grndate') is-invalid @enderror" >
                                    @error('grndate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="po_id">Purchase Order Number *</label>
                                    <select name="po_id" id="po_id" class="form-control @error('po_id') is-invalid @enderror">
                                    <option value=""></option>
                                    @forelse ($po_datas as $code)
                                        <option value="{{$code->id}}">{{$code->rcmaster->rc_id}}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                    @error('po_id')
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
                                    <label for="rm_id">RM Description *</label>
                                    <select name="rm_id" id="rm_id" class="form-control @error('rm_id') is-invalid @enderror">
                                    <option value=""></option>
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
                                    <label for="po_qty">Purchase Order Quantity *</label>
                                    <input type="number" name="po_qty" id="po_qty" readonly class="form-control @error('po_qty') is-invalid @enderror" >
                                    @error('po_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="max_qty">Maximum Quantity *</label>
                                    <input type="number" name="max_qty" id="max_qty" readonly class="form-control @error('max_qty') is-invalid @enderror" >
                                    @error('max_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice No *</label>
                                    <input type="text" name="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" >
                                    @error('invoice_number')
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
                                    <label for="invoice_date">Invoice Date *</label>
                                    <input type="date" name="invoice_date" id="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" >
                                    @error('invoice_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dc_number">DC No *</label>
                                    <input type="text" name="dc_number" id="dc_number" class="form-control @error('dc_number') is-invalid @enderror" >
                                    @error('dc_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dc_date">DC Date *</label>
                                    <input type="date" name="dc_date" id="dc_date" class="form-control @error('dc_date') is-invalid @enderror" >
                                    @error('dc_date')
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
                                <tr class="bg-info text-white">
                                    <th>Rack ID</th>
                                    <th>Heat No</th>
                                    <th>Test Certificate No</th>
                                    <th>Lot No</th>
                                    <th>Coil No</th>
                                    <th>Quantity</th>
                                    <th>Unit Of Measurement (UOM)</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="saved">
                                    <td><select name="rack_id[]"  class="form-control rack_id" id="rack_id"></select></td>
                                    <td><input type="text" class="form-control heatnumber"  name="heatnumber[]" id="heatnumber"></td>
                                    <td><input type="text"  class="form-control tc_no" name="tc_no[]" id="tc_no"></td>
                                    <td><input type="text" class="form-control lot_no" id="lot_no" name="lot_no[]"></td>
                                    <td><input type="number"  class="form-control coil_no" name="coil_no[]" id="coil_no"></td>
                                    <td><input type="number" class="form-control coil_inward_qty" name="coil_inward_qty[]" id="coil_inward_qty"></td>
                                    <td><select name="uom_id[]"  class="form-control bg-white uom_id" id="uom_id"></td>
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
                        <div class="col-2"><input type="number" name="grand_total" class="form-control" id="grand_total"  readonly></div>
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

@push('scripts')
<script>
$(document).ready(function(){
    $('input').on('input', function() {
        var inputId = $(this).attr('id');
        $('#' + inputId + '-error').remove();
    });
});
$("#po_id").select2({
        placeholder:"Select Purchase Order",
        allowedClear:true
    });
    $("#rm_id").select2({
        placeholder:"Select RM",
        allowedClear:true
    });

    $(".rack_id").select2({
        placeholder:"Select Rack ID",
        allowedClear:true
    });
    $(".uom_id").select2({
        placeholder:"Select UOM",
        allowedClear:true
    });

    $('#po_id').change(function (e) {
        e.preventDefault();
        var po_id=$(this).val();
        // alert(po_id);
        $.ajax({
            url: "{{route('grn_supplierfetchdata')}}?id=" + $(this).val(),
            method: 'GET',
            cache:false,
            processData:false,
            contentType:false,
            success : function(result){
                // console.log(result);
                // alert(result);
                if (result.count > 0) {
                    $('#name').val(result.sc_name);
                    $('#name'). attr('readonly','true');
                    $('#rm_id').html(result.html);
                }else{
                    $('#name').val('');
                    $('#name'). attr('readonly','true');
                }
            }
        });
    });

    $("#rm_id").change(function (e) {
        e.preventDefault();
        var rm_id=$(this).val();
        // alert(rm_id);
        // console.log(rm_id);
        $.ajax({
            url: "{{route('grn_rmfetchdata')}}?id=" + $(this).val(),
            method: 'GET',
            cache:false,
            processData:false,
            contentType:false,
            success : function(result){
                console.log(result);
                if (result.count > 0) {
                    $('#max_qty').val(result.max_qty);
                    $('#max_qty'). attr('readonly','true');
                    $('#po_qty').val(result.po_qty);
                    $('#po_qty'). attr('readonly','true');
                    $('#grand_total'). attr('max',result.po_qty);
                    $('#rack_id').html(result.html);
                    $('#uom_id').html(result.uom);
                }else{
                    $('#max_qty').val('');
                    $('#max_qty'). attr('readonly','true');
                }
            }
        });
    });

    $("#add_row").click(function(){
        var po_id = $("#po_id").val();
        var rm_id = $("#rm_id").val();
        if(po_id==""){
            alert("Please select Purchaser Order!");
            return false;
        }
        if(rm_id==""){
            alert("Please select RM Description!");
            return false;
        }
        $.ajax({
            url:"{{route('add_grn_item')}}",
            type:"POST",
            data:{"po_id":po_id,"rm_id":rm_id},
            success:function(response){
                $("#tab_logic").append(response.category);
                $(".rack_id").select2({
                    placeholder:"Select Rack ID",
                    allowedClear:true
                });
                $(".uom_id").select2({
                    placeholder:"Select UOM",
                    allowedClear:true
                });
            }
        });
    });
    $("#coil_inward_qty").change(updateGrandTotal);
    function updateGrandTotal()
    {
        var grandTotal = 0;
        $('table > tbody  > tr').each(function(index, row) {
        // console.log($(row).find('.coil_inward_qty').val());
            var qty = ($(row).find('.coil_inward_qty').val());
            grandTotal+=parseFloat(qty);
            $("#grand_total").val(grandTotal);
        });
     }
    $("#tab_logic").on('change', 'input', updateGrandTotal);
    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $("#grn_inward_formdata").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#grn_inward_formdata")[0]);
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
                        if(data.errors) {
                            var values = '';
                            jQuery.each(data.errors, function (key, value) {
                                values += value
                            });

                            swal({
                                title: "Error",
                                text: values,
                                timer: 5000,
                                showConfirmButton: false,
                                type: "error"
                            })
                        }
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
                            'GRN is Created Successfully!...',
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
                    'Your GRN Data is safe',
                    'error'
                    )
                }
            });
        });
    $("#reset").click(function (e) {
        e.preventDefault();
        location.reload(true);
    });

</script>
@endpush

