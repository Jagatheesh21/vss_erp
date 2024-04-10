@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Invoice Correction Approval</b></span>
                <a class="btn btn-sm btn-primary" href="{{route('invoicecorrectionmaster.index')}}">Invoice List</a>
            </div>
            <div class="row col-md-3"id="res"></div>

            <div class="card-body">

                    <form action="{{route('invoicecorrectionmaster.update',$invoicecorrectionmasterDatas->id)}}" id="invoicecorrection_formdata"  method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <input type="hidden" name="id" value="{{$invoicecorrectionmasterDatas->id}}">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice Number *</label>
                                    <select name="invoice_number" id="invoice_number" class="form-control bg-light @error('invoice_number') is-invalid @enderror">
                                        <option name="invoice_number" value="{{$invoicecorrectionmasterDatas->invoicedetails->id}}" selected>{{$invoicecorrectionmasterDatas->invoicedetails->rcmaster->rc_id}}</option>
                                    </select>
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
                                    <input type="date" id="invoice_date" name="invoice_date" class="form-control bg-light @error('invoice_date') is-invalid @enderror" value="{{$invoicecorrectionmasterDatas->invoicedetails->invoice_date}}" readonly>
                                    @error('invoice_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cus_id">Customer Name *</label>
                                    <select name="cus_id" id="cus_id" @readonly(true) class="form-control bg-light @error('cus_id') is-invalid @enderror">
                                        <option name="cus_id" value="{{$invoicecorrectionmasterDatas->invoicedetails->customerpomaster->customermaster->id}}" selected>{{$invoicecorrectionmasterDatas->invoicedetails->customerpomaster->customermaster->cus_name}}</option>
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
                                    <label for="part_id">Part Name *</label>
                                    <select name="part_id" id="part_id" @readonly(true) class="form-control bg-light @error('part_id') is-invalid @enderror">
                                        <option name="part_id" value="{{$invoicecorrectionmasterDatas->invoicedetails->productmaster->id}}" selected>{{$invoicecorrectionmasterDatas->invoicedetails->productmaster->part_no}}</option>
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
                                    <label for="">Total Quantity *</label>
                                    <input type="Number" name="qty" id="qty" @readonly(true) class="form-control  bg-light @error('qty') is-invalid @enderror" value="{{$invoicecorrectionmasterDatas->invoicedetails->qty}}" readonly >
                                    @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="correction_request_date">Invoice Correction Request Date *</label>
                                    <input type="date" id="correction_request_date" name="correction_request_date" class="form-control bg-light @error('correction_request_date') is-invalid @enderror" value="{{$invoicecorrectionmasterDatas->correction_request_date}}" readonly>
                                    @error('correction_request_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="request_reason">CORRECTION REQUEST REASON *</label>
                                    <textarea name="request_reason" id="request_reason" @readonly(true) class="form-control bg-light @error('request_reason') is-invalid @enderror" cols="20" rows="3">{{$invoicecorrectionmasterDatas->request_reason}}</textarea>
                                    @error('request_reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">STATUS *</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" @if($invoicecorrectionmasterDatas->status==0) selected @endif>Pending</option>
                                        <option value="3" @if($invoicecorrectionmasterDatas->status==3) selected @endif >Approve</option>
                                        <option value="2" @if($invoicecorrectionmasterDatas->status==2) selected @endif>Reject</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row" id="rejected_reason">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="approved_reason">REJECT REASON *</label>
                                    <textarea name="approved_reason" id="approved_reason" class="form-control @error('approved_reason') is-invalid @enderror" cols="20" rows="3">{{$invoicecorrectionmasterDatas->approved_reason}}</textarea>
                                    @error('approved_reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center ">
                            <div class="col-md-2 mt-4">
                                <input type="submit" class="btn btn-success  text-white align-center" id="btn" value="Submit">
                                <input class="btn btn-danger text-white" id="reset" type="reset" value="Reset">
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}" ></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#status").select2();
        $('#rejected_reason').hide();
        $("#status").change(function (e) {
            e.preventDefault();
            var status=$(this).val();
            if (status==2) {
                $('#rejected_reason').show();
            }else{
                $('#rejected_reason').hide();
            }
        });
        $("#reset").click(function (e) {
            e.preventDefault();
            location.reload(true);
        });
    });
    </script>
    @endsection
