@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Delivery challan</h3>
            </div>
            <div class="card-body">
                <form action="">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="" class="label-required">DC No.</label>
                                <input type="text" name="dc_number" class="form-control" placeholder="DC Number" value="1234">
                            </div>
                        </div>
                        
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">To Operation</label>
                                <select name="to_operation_id" id="to_operation_id" class="form-control">
                                    @forelse ($operations as $operation)
                                        <option value="{{$operation->id}}" selected="selected"> {{$operation->operation}}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    <option value="">Select Supplier</option>
                                    @forelse ($suppliers  as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->supplier_code}}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Partnumber</label>
                                <select name="part_id" id="part_id" class="form-control">
                                    <option value="">Select Partnumber</option>
                                    @forelse ($part_numbers as $part_number)
                                        <option value="{{$part_number->id}}">{{$part_number->part_no}}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                            </div>
                        </div>
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
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="route_card_id[]"></td>
                                    <td><input type="text" class="form-control" name="available_quantity[]"></td>
                                    <td><input type="text" class="form-control" name="issue_quantity[]"></td>
                                </tr>
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
    </script>
@endpush