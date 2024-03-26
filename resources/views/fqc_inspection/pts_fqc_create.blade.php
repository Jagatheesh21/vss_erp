@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />
<form action="{{route('fqc_approval.store')}}" id="fqc_formdata" method="POST">
    @csrf
    @method('POST')
    <div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>New Final Quality Inspection Register </b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('ptsfqclist')}}"><b>&nbsp;&nbsp;Final Quality Inspection List</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="form-check-input select_all" name="select_all" id="select_all"></th>
                                    <th>Offer Date</th>
                                    <th>Previous Stage</th>
                                    <th>Next Stage</th>
                                    <th>Part Number</th>
                                    <th>Route Card Number</th>
                                    <th>Previous Route Card Number</th>
                                    <th>Offered Qty</th>
                                    <th>Inspected Qty*</th>
                                    <th>Status*</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fqcDatas as $fqcData)
                                <tr id="tr_{{$fqcData->id}}">
                                    <input type="hidden"  class="form-control previous_product_process_id bg-light" readonly value="{{$fqcData->product_process_id}}" name="previous_product_process_id[]" id="previous_product_process_id">
                                    <input type="hidden"  class="form-control next_productprocess_id bg-light" readonly value="{{$fqcData->next_product_process_id}}" name="next_productprocess_id[]" id="next_productprocess_id">
                                    <input type="hidden"  class="form-control rc_status bg-light" readonly value="{{$fqcData->rc_status}}" name="rc_status[]" id="rc_status">
                                    <td><input type="checkbox" class="form-check-input fqc_id" name="fqc_id[]" data-id="{{$fqcData->id}}" value="{{$fqcData->id}}"></td>
                                    <td>{{$fqcData->offer_date}}</td>
                                    <td><select name="previous_process_id[]"  class="form-control previous_process_id bg-light" readonly id="previous_process_id">
                                        <option value="{{$fqcData->currentprocessmaster->id}}" selected>{{$fqcData->currentprocessmaster->operation}}</option></select></td>
                                    <td><select name="next_process_id[]"  class="form-control next_process_id bg-light" readonly id="next_process_id">
                                            <option value="{{$fqcData->nextprocessmaster->id}}" selected>{{$fqcData->nextprocessmaster->operation}}</option></select></td>
                                    <td><select name="part_id[]"  class="form-control part_id bg-light" readonly id="part_id">
                                            <option value="{{$fqcData->partmaster->id}}" selected>{{$fqcData->partmaster->child_part_no}}</option></select></td>
                                    <td><select name="rc_id[]"  class="form-control rc_id bg-light" readonly id="rc_id">
                                                <option value="{{$fqcData->current_rcmaster->id}}" selected>{{$fqcData->current_rcmaster->rc_id}}</option></select></td>
                                    <td><select name="previous_rc_id[]"  class="form-control previous_rc_id bg-light" readonly id="previous_rc_id">
                                                    <option value="{{$fqcData->previous_rcmaster->id}}" selected>{{$fqcData->previous_rcmaster->rc_id}}</option></select></td>

                                    <td><input type="number" class="form-control offer_qty" name="offer_qty[]" value="{{$fqcData->offer_qty}}" id="offer_qty"></td>
                                    <td><input type="number" class="form-control inspect_qty" name="inspect_qty[]" min="0" max="{{$fqcData->offer_qty}}" value="{{$fqcData->inspect_qty}}" id="inspect_qty"></td>
                                    <td>
                                        <select name="status[]" id="status" class="form-control status">
                                            <option value="0" @if($fqcData->status==0) selected @endif >PENDING</option>
                                            <option value="1" @if($fqcData->status==1) selected @endif>APPROVED</option>
                                            <option value="2" @if($fqcData->status==2) selected @endif>REJECTED</option>
                                            <option value="3" @if($fqcData->status==3) selected @endif>ON-HOLD</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="reason[]" id="reason" class="form-control reason" cols="30" rows="5"></textarea>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="16" align="center">No Records Found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                    <div class="col-md-4">
                        <label for="status_all">Reason All</label>
                        <textarea name="reason_all" id="reason_all" class="form-control" cols="30" rows="5"  style="display: none;"></textarea>
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
$(".status").select2({
        placeholder:"Select Status",
        allowedClear:true
    });
    $(".status_all").select2({
        placeholder:"Select Status",
        allowedClear:true
    });
$('.fqc_id').change(function (e) {
    e.preventDefault();
    getRow();
});

    $('.select_all').on('click', function(e) {
          if($(this).is(':checked',true))
          {
              $(".fqc_id").prop('checked', true);
          } else {
              $(".fqc_id").prop('checked',false);
          }
    });
    $('.status_all').change(function (e) {
        e.preventDefault();
        var allStatus=$(this).val();
        // alert(allStatus);
        if (allStatus==0) {
            alert('Please Select Other Status');
          $('#reason_all').hide();
          $(".select_all").prop('checked', false);
          $(".fqc_id").prop('checked', false);

        }
        if (allStatus==1) {
            $('#status').html('<option value="1"selected>APPROVED</option>');
          $('#reason_all').hide();
          $(".select_all").prop('checked', true);
          $(".fqc_id").prop('checked', true);

        }
        if (allStatus==2) {
            $('#status').html('<option value="2"selected>REJECTED</option>');
          $('#reason_all').show();
        $(".select_all").prop('checked', true);
        $(".fqc_id").prop('checked', true);

        }
        if (allStatus==3) {
            $('#status').html('<option value="3"selected>ON-HOLD</option>');
          $('#reason_all').show();
        $(".select_all").prop('checked', true);
        $(".fqc_id").prop('checked', true);
        }


    });

    function getRow(){
        // $('table > tbody  > tr > td.fqc_id').each(function(index, row) {
        //     if($(".fqc_id").is(':checked',true))
        //   {
        //       $(".select_all").prop('checked', true);
        //   } else {
        //       $(".select_all").prop('checked',false);
        //   }
        // });
        $("table > tbody  > tr").each(function () {
            var isChecked = $(".fqc_id input:checkbox").checked;
            // $(this).find('td .fqc_id').each(function () {
                if(isChecked){
                    $(".select_all").prop('checked', true);
                }
            // });
        });
    }



    $('.status').change(function (event) {
        $(this).closest("tr").find('td .fqc_id').prop('checked', true);
        // getRow();
    });


    $('.update_all').on('click', function(e) {

            var allVals = [];
            $(".fqc_id:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if(allVals.length <=0)
            {
                alert("Please select row.");
                return false;
            }  else {
                var check = confirm("Are you sure you want to submit inspection data this row?");
                if(check == true){
                    var join_selected_values = allVals.join(",");
                    alert(join_selected_values);
                }else{
                    return false;
                }
            }
        });
   $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });
    $(".save").click(function (e) {
            e.preventDefault();
            var allVals = [];
            $(".fqc_id:checked").each(function() {
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

