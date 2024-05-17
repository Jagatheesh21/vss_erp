@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('rmdc.store')}}" id="delivery_challan_formdata" method="POST">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
        <div class="row col-md-3"id="res"></div>
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Create RM Delivery challan</b></span><a class="btn btn-sm btn-primary" href="{{route('delivery_challan.index')}}">Delivery challan List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dc_number">DC No. *</label>
                                    <input type="text" name="dc_number" id="dc_number" value="{{$new_rcnumber}}" readonly class="form-control bg-light @error('dc_number') is-invalid @enderror" >
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
                                    <input type="date" name="dc_date" id="dc_date" value="{{$current_date}}" readonly class="form-control bg-light @error('dc_date') is-invalid @enderror" >
                                    @error('dc_date')
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
                                    @forelse ($dcmasterDatas as $dcmasterData)
                                        <option value="{{$dcmasterData->supplier->id}}">{{$dcmasterData->supplier->supplier_code}}</option>
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
                                    <label for="rm_id">RM Number *</label>
                                    <select name="rm_id" id="rm_id" class="form-control rm_id  @error('rm_id') is-invalid @enderror">
                                        <option value="">Select RM Number</option>
                                    </select>
                                    @error('rm_id')
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
                                    <label for="grn_id">GRN Number *</label>
                                    <select name="grn_id" id="grn_id" class="form-control grn_id  @error('grn_id') is-invalid @enderror">
                                        <option value="">Select The GRN Number</option>
                                    </select>
                                    @error('grn_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="operation_id">Operation *</label>
                                    <select name="operation_id" id="operation_id" class="form-control operation_id  @error('operation_id') is-invalid @enderror">
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
                                    <label for="avl_quantity">DC Available Quantity*</label>
                                    <input type="number" name="avl_quantity" id="avl_quantity" step="0.001" class="form-control @error('avl_quantity') is-invalid @enderror" >
                                    @error('avl_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dc_quantity">DC Quantity *</label>
                                    <input type="number" name="dc_quantity" min="0" step="0.001" id="dc_quantity" class="form-control @error('dc_quantity') is-invalid @enderror" >
                                    @error('dc_quantity')
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
                        <div class="row clearfix mt-3" id="step1">

                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button class="btn btn-primary mt-4">Proceed DC</button>
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
        $("#supplier_id").select2();
        $("#rm_id").select2();
        $("#grn_id").select2();
        $("#trans_mode").select2();
        $('#supplier_id').change(function (e) {
            e.preventDefault();
            var supplier_id=$(this).val();
            // alert(supplier_id);
            $.ajax({
                type: "GET",
                url: "{{route('dcrmsupplierdata')}}",
                data: {"supplier_id":supplier_id},
                success: function (response) {
                    console.log(response);
                    if(response.count > 0){
                    $('#rm_id').html(response.rm_id);
                    }else{
                        alert('Please Choose Supplier...');
                    }
                }
            });
        });
        $('#rm_id').change(function (e) {
                e.preventDefault();
                var supplier_id=$("#supplier_id").val();
                var rm_id=$(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('dcrmgrndata')}}",
                    data: {"supplier_id":supplier_id,"rm_id":rm_id},
                    success: function (response) {
                        // console.log(response);
                        $('#operation_id').html(response.operation);
                        $('#grn_id').html(response.grn_id);
                    }
                });
            });
            $('#grn_id').change(function (e) {
                e.preventDefault();
                var supplier_id=$("#supplier_id").val();
                var rm_id=$("#rm_id").val();
                var grn_id=$(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('dcrmgrncoildata')}}",
                    data: {"supplier_id":supplier_id,"rm_id":rm_id,"grn_id":grn_id},
                    success: function (response) {
                        // console.log(response);
                        $('#avl_quantity').val(response.grn_avl_kg);
                        $('#step1').html(response.html);

                    }
                });
            });
            $('#dc_quantity').change(function (e) {
                e.preventDefault();
                var dc_quantity=$(this).val();
                var total = dc_quantity;
                $('table > tbody  > tr').each(function(index, row) {
                    $(row).find('.issue_quantity').val('');
                    var qty = $(row).find('.available_quantity').val();
                    if(total>=qty && total>0){
                        total-=qty;
                        $(row).find('.issue_quantity').val(qty);
                    }else if(qty>total){
                        $(row).find('.issue_quantity').val(total);
                        total = 0;
                    }
                    var balance = qty-($(row).find('.issue_quantity').val());
                        $(row).find('.balance').val(balance);
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

    </script>
@endpush
