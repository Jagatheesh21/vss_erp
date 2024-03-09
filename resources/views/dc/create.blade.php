@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Delivery</h3>
            </div>
            <div class="card-body">
                <form action="">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="" class="label-required">DC No.</label>
                                <input type="text" name="dc_number" class="form-control" placeholder="DC Number" @readonly(true) value="{{$new_rcnumber}}">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="">To Operation</label>
                                <select name="to_operation_id" id="to_operation_id" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    <option value="" selected>Select Supplier</option>
                                    @forelse ($dcmasterDatas as $dcmasterData)
                                    <option value="{{$dcmasterData->supplier->id}}"> {{$dcmasterData->supplier->supplier_code}}</option>
                                @empty

                                @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="part_id">Partnumber</label>
                                <select name="part_id" id="part_id" class="form-control">
                                    <option value="">Select Partnumber</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">DC Quantity</label>
                                <input type="text" class="form-control" name="dc_quantity" id="dc_quantity">
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary mt-4">Proceed DC</button>
                        </div>
                    </div>
                    <div class="row py-5">
                        <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                               <tr>
                                <th>Route Card</th>
                                <th>Available Quantity</th>
                                <th>DC Quantity</th>
                               </tr>
                            </thead>
                            <tbody id="table_logic">

                            </tbody>
                        </table>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $("#supplier_id").select2();
        $("#operation_id").select2();
        $("#part_id").select2();
        $('#supplier_id').change(function (e) {
            e.preventDefault();
            var supplier_id=$(this).val();
            // alert(supplier_id);
            $.ajax({
                type: "GET",
                url: "{{route('dcpartdata')}}",
                data: {"supplier_id":supplier_id},
                success: function (response) {
                    console.log(response);
                    if(response.count > 0){
                    $('#part_id').html(response.part_id);
                    }else{
                        alert('Please Choose Supplier...');
                    }
                }
            });
            $('#part_id').change(function (e) {
                e.preventDefault();
                var supplier_id=$("#supplier_id").val();
                var part_id=$(this).val();
            alert(supplier_id);
            alert(part_id);
                $.ajax({
                    type: "POST",
                    url: "{{route('dcitemrc')}}",
                    data: {"supplier_id":supplier_id,"part_id":part_id},
                    success: function (response) {
                        console.log(response);
                        $('#dc_quantity').val(response.t_avl_qty);
                        $('#table_logic').html(response.table);
                    }
                });
            });
        });
    </script>
@endpush
