@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<form action="{{route('invoicereprintpdf')}}" id="delivery_challan_formdata" method="POST" target="_blank">
    @csrf
    @method('POST')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
        <div class="row col-md-3"id="res"></div>
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Invoice RePrint</b></span><a class="btn btn-sm btn-primary" href="{{route('invoicedetails.index')}}">Invoice List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="invoice_id">
                                    <label for="invoice_number">Invoice No. *</label>
                                    <select name="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror">
                                        <option value="" selected>Select The Invoice Number</option>
                                        @foreach ($invoiceDatas as $invoiceData)
                                            <option value="{{$invoiceData->rcmaster->id}}">{{$invoiceData->rcmaster->rc_id}}</option>
                                        @endforeach
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
                                    <input type="date" name="invoice_date" id="invoice_date"  readonly class="form-control bg-light @error('invoice_date') is-invalid @enderror" >
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
                                    </select>
                                    @error('part_id')
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
                                    <button class="btn btn-primary mt-4" id="proceed">Print</button>
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
        $("#invoice_number").select2();
        $("#invoice_number").change(function (e) {
            e.preventDefault();
            var invoice_number=$(this).val();
            // alert(invoice_number);
            $.ajax({
                type: "GET",
                url: "{{route('invoicereprintfetchdata')}}",
                data: {"invoice_number":invoice_number},
                success: function (response) {
                    $('#invoice_id').val(response.invoice_id);
                    $('#invoice_date').val(response.invoice_date);
                    $('#cus_id').html(response.cus_id);
                    $('#part_id').html(response.part_id);
                }
            });
        });
</script>
@endpush

