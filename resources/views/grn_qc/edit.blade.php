@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('grn_qc.update',$grnqc_datas[0]->id)}}" id="grn_qc_formdata" method="POST">
    @csrf
    @method('PUT')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
    <div class="col-12">
        <div class="row col-md-3"id="res"></div>

        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>GRN Incoming Quality Clearance</b></span><a class="btn btn-sm btn-primary" href="{{route('grn_qc.index')}}">GRN Incoming QC List</a>
            </div>
            <input type="hidden" name="id" value="{{$grnqc_datas[0]->id}}">
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="grnnumber">GRN Number *</label>
                                    <select name="grnnumber" class="form-control bg-light @error('grnnumber') is-invalid @enderror" readonly  id="grnnumber">
                                        <option value="{{$grnqc_datas[0]->grn_id}}" selected>{{$grnqc_datas[0]->grnnumber}}</option>
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
                                    <label for="grndate">GRN Date *</label>
                                    <input type="date" name="grndate" id="grndate" value="{{$grnqc_datas[0]->grndate}}" readonly class="form-control bg-light @error('grndate') is-invalid @enderror" >
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
                                    <select name="po_id" class="form-control bg-light @error('po_id') is-invalid @enderror" readonly id="po_id">
                                        <option value="{{$grnqc_datas[0]->po_id}}" selected>{{$grnqc_datas[0]->ponumber}}</option>
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
                                    <label for="sc_id">Supplier Name *</label>
                                    <select name="sc_id" class="form-control bg-light @error('sc_id') is-invalid @enderror" @readonly(true) id="sc_id">
                                        <option value="{{$grnqc_datas[0]->sc_id}}" selected>{{$grnqc_datas[0]->sc_name}}</option>
                                    </select>
                                    @error('sc_id')
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
                                    <select name="rm_id" id="rm_id" class="form-control bg-light @error('rm_id') is-invalid @enderror" @readonly(true)>
                                        <option value="{{$grnqc_datas[0]->rm_id}}" selected>{{$grnqc_datas[0]->rm_desc}}</option>
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
                                    <label for="invoice_number">Invoice No *</label>
                                    <input type="text" name="invoice_number" id="invoice_number" value="{{$grnqc_datas[0]->invoice_number}}" class="form-control bg-light @error('invoice_number') is-invalid @enderror" @readonly(true)>
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
                                    <input type="date" name="invoice_date" id="invoice_date" value="{{$grnqc_datas[0]->invoice_date}}" class="form-control  bg-light @error('invoice_date') is-invalid @enderror" @readonly(true)>
                                    @error('invoice_date')
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
                                    <label for="dc_number">DC No *</label>
                                    <input type="text" name="dc_number" id="dc_number" value="{{$grnqc_datas[0]->dc_number}}" class="form-control  bg-light @error('dc_number') is-invalid @enderror" @readonly(true)>
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
                                    <input type="date" name="dc_date" id="dc_date" value="{{$grnqc_datas[0]->dc_date}}" class="form-control  bg-light @error('dc_date') is-invalid @enderror" @readonly(true)>
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
                                    <th><input type="checkbox" class="form-check-input select_all" name="select_all" id="select_all"></th>
                                    <th>Rack ID</th>
                                    <th>Heat Number </th>
                                    <th>Test Certificate No</th>
                                    <th>Lot No</th>
                                    <th>Coil No</th>
                                    <th>Unit Of Measurement (UOM)</th>
                                    <th>RM Inward Quantity</th>
                                    <th>RM Approved Quantity</th>
                                    <th>RM Rejected Quantity</th>
                                    <th>RM On-Hold Quantity</th>
                                    <th>Inspected By</th>
                                    <th>Inspected Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($grnqc_datas as $grnqc_data)
                                <tr id="tr_{{$grnqc_data->id}}">
                                        <td><input type="checkbox" class="form-check-input sub_id" name="sub_id[]" data-id="{{$grnqc_data->id}}" value="{{$grnqc_data->id}}"></td>
                                        <td><select name="rack_id[]"  class="form-control rack_id bg-light" readonly id="rack_id">
                                            <option value="{{$grnqc_data->rack_id}}" selected>{{$grnqc_data->rack_name}}</option></select></td>
                                        <td><select name="heat_id[]"  class="form-control heat_id bg-light" readonly id="heat_id">
                                                <option value="{{$grnqc_data->heat_id}}" selected aria-placeholder="SELECT HEAT NUMBER">{{$grnqc_data->heatnumber}}</option></select></td>
                                        <td><input type="text"  class="form-control tc_no bg-light" readonly value="{{$grnqc_data->tc_no}}" name="tc_no[]" id="tc_no"></td>
                                        <td><input type="text" class="form-control lot_no bg-light" readonly value="{{$grnqc_data->lot_no}}" id="lot_no" name="lot_no[]"></td>
                                        <td><input type="number"  class="form-control coil_no bg-light" readonly value="{{$grnqc_data->coil_no}}" name="coil_no[]" id="coil_no"></td>
                                        <td><select name="uom_id[]"  class="form-control uom_id bg-light" @readonly(true) id="uom_id"><option value="{{$grnqc_data->uom_id}}" selected>{{$grnqc_data->uom_name}}</option></select></td>
                                        <td><input type="number" class="form-control coil_inward_qty bg-light" readonly name="coil_inward_qty[]" value="{{$grnqc_data->coil_inward_qty}}" id="coil_inward_qty"></td>
                                        <td><input type="number" class="form-control approved_qty bg-light" readonly name="approved_qty[]" value="{{$grnqc_data->approved_qty}}" id="approved_qty"></td>
                                        <td><input type="number" class="form-control rejected_qty bg-light" readonly name="rejected_qty[]" value="{{$grnqc_data->rejected_qty}}" id="rejected_qty"></td>
                                        <td><input type="number" class="form-control onhold_qty bg-light" readonly name="onhold_qty[]" value="{{$grnqc_data->onhold_qty}}" id="onhold_qty"></td>
                                        <td><input type="text" class="form-control inspected_by bg-light" @readonly(true) name="inspected_by[]" value="{{$grnqc_data->inspected_by}}" id="inspected_by"></td>
                                        <td><input type="date" class="form-control inspected_date bg-light" @readonly(true) name="inspected_date[]" value="{{$grnqc_data->inspected_date}}" id="inspected_date"></td>
                                        <td> <select name="status[]" data-id="{{$grnqc_data->id}}" class="form-control select2 status" id="status">
                                            <option value="0" @if($grnqc_data->status==0) selected @endif >PENDING</option>
                                            <option value="1" @if($grnqc_data->status==1) selected @endif>APPROVED</option>
                                            <option value="2" @if($grnqc_data->status==2) selected @endif>REJECTED</option>
                                            <option value="3" @if($grnqc_data->status==3) selected @endif>ON-HOLD</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="14" align="center">No Records Found!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    <div class="row mb-3 d-flex justify-content-end clearfix">
                        <div class="col-2"><h6>Grand Total:</h6></div>
                        <div class="col-2">
                            <input type="text" name="grand_total" class="form-control @error('grand_total') is-invalid @enderror" id="grand_total" readonly>

                        </div>
                    </div>

                    <div class="row d-flex justify-content-center ">

                        <div class="col-md-4">
                            <label for="status_all">Status All</label>
                            <select name="status_all" class="form-control select2 status_all" id="status_all">
                                <option value="0">PENDING</option>
                                <option value="1">APPROVED</option>
                                <option value="2">REJECTED</option>
                                <option value="3">ON-HOLD</option>
                            </select>
                            @error('status_all')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="col-md-4 mt-4">
                            <button class="btn btn-primary update_all" id="update_all" name="update_all" value="1" style="display: none;" >Save All</button>
                            <button class="btn btn-primary update_all" id="update_all" name="update_all" value="1"  >Save</button>
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
$(".heat_id").select2({
        placeholder:"Select Heat Number",
        allowedClear:true
    });
$('.sub_id').change(function (e) {
    e.preventDefault();
    getRow();
});

    $('.select_all').on('click', function(e) {
          if($(this).is(':checked',true))
          {
              $(".sub_id").prop('checked', true);
          } else {
              $(".sub_id").prop('checked',false);
          }
    });
    $('.status_all').change(function (e) {
        e.preventDefault();
        var allStatus=$(this).val();
        // alert(allStatus);
        if (allStatus==0) {
            alert('Please Select Other Status');
        }
        if (allStatus==1) {
            $('#status').html('<option value="1"selected>APPROVED</option>');
        }
        if (allStatus==2) {
            $('#status').html('<option value="2"selected>REJECTED</option>');
        }
        if (allStatus==3) {
            $('#status').html('<option value="3"selected>ON-HOLD</option>');
        }
    });

    function getRow(){
        // $('table > tbody  > tr > td.sub_id').each(function(index, row) {
        //     if($(".sub_id").is(':checked',true))
        //   {
        //       $(".select_all").prop('checked', true);
        //   } else {
        //       $(".select_all").prop('checked',false);
        //   }
        // });
        $("table > tbody  > tr").each(function () {
            var isChecked = $(".sub_id input:checkbox").checked;
            // $(this).find('td .sub_id').each(function () {
                if(isChecked){
                    $(".select_all").prop('checked', true);
                }
            // });
        });
    }



    $('.status').change(function (event) {
        $(this).closest("tr").find('td .sub_id').prop('checked', true);
        getRow();
    });


    $('.update_all').on('click', function(e) {

            var allVals = [];
            $(".sub_id:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if(allVals.length <=0)
            {
                alert("Please select row.");
                return false;
            }  else {
                var check = confirm("Are you sure you want to delete this row?");
                if(check == true){
                    var join_selected_values = allVals.join(",");
                    alert(join_selected_values);
                }else{
                    return false;
                }
            }
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
    $(".save").click(function (e) {
            e.preventDefault();
            var allVals = [];
            $(".sub_id:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if(allVals.length <=0)
            {
                alert("Please select row.");
                return false;
            }  else {
                alert(allVals);
            }
    });
    $("#reset").click(function (e) {
        e.preventDefault();
        location.reload(true);
    });

</script>
@endpush

