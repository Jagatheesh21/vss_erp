@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
        <form action="{{route('dcprint.store')}}" id="dc_print_formdata" method="POST">
            @csrf
            @method('POST')
            <div class="card">
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
                @if (session()->has('message'))
                    <div class="alert alert-danger mt-4">
                    {{ session()->get('message')}}
                    </div>
                @endif
                <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Multi Delivery challan List</b> </span>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="s_no">DC S.No *</label>
                                <select name="s_no" id="s_no" class="form-control bg-light s_no  @error('s_no') is-invalid @enderror" @readonly(true)>
                                    <option value="" >Select DC S.No</option>
                                    <option value="{{$dc_sno}}" selected>{{'DC-U1-'.$dc_sno}}</option>
                                </select>
                                @error('s_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="supplier_id">Supplier Code *</label>
                                <select name="supplier_id" id="supplier_id" class="form-control supplier_id  @error('supplier_id') is-invalid @enderror">
                                    <option value="" selected>Select Supplier</option>
                                    @foreach ($dcsupplierDatas as $dcsupplierData)
                                    <option value="{{$dcsupplierData->supplier->id}}">{{$dcsupplierData->supplier->supplier_code}}</option>
                                    @endforeach
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
                                <button class="btn btn-primary update_all mt-4" id="update_all" name="update_all" value="1">Proceed DC Multi Print</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input select_all" name="select_all" id="select_all"></th>
                                        <th>DC Number</th>
                                        <th>DC Date</th>
                                        <th>Part No</th>
                                        <th>Quantity</th>
                                        <th>UOM</th>
                                        <th>Unit Rate</th>
                                        <th>Total Value</th>
                                    </tr>
                                </thead>
                                <tbody id="table_logic">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
        $("#supplier_id").select2();
        $("#supplier_id").change(function (e) {
            e.preventDefault();
            var supplier_id=$(this).val();
            // alert(supplier_id);
            $.ajax({
                type: "POST",
                url: "{{route('dcsupplierprintdata')}}",
                data: {"supplier_id":supplier_id},
                success: function (response) {
                    $('#table_logic').html(response.table);
                }
            });
        });
        $('.select_all').on('click', function(e) {
          if($(this).is(':checked',true))
          {
              $(".sub_id").prop('checked', true);
          } else {
              $(".sub_id").prop('checked',false);
          }
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
                var check = confirm("Are you sure you want to submit inspection data this row?");
                if(check == true){
                    var join_selected_values = allVals.join(",");
                    alert(join_selected_values);
                }else{
                    return false;
                }
            }
        });
</script>
@endpush
