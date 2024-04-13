@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
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
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Invoice List</b> </span>
                <a class="btn btn-sm btn-info text-white" href="{{route('invoicecorrectionmaster.create')}}">Correction Request</a>
                <a class="btn btn-sm btn-info text-white" href="{{route('invoiceprint')}}">Print</a>
                <a class="btn btn-sm btn-primary text-white" href="{{route('invoicedetails.create')}}">New</a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Customer Code</th>
                                    <th>Customer Name</th>
                                    <th>Customer Billing Address</th>
                                    <th>Customer Billing Address2</th>
                                    <th>Customer Billing City</th>
                                    <th>Customer Billing State</th>
                                    <th>Customer Billing Country</th>
                                    <th>Customer Billing Pincode</th>
                                    <th>Customer Billing GST No</th>
                                    <th>Customer Billing PAN No</th>
                                    <th>Customer Name</th>
                                    <th>Customer Shipping Address</th>
                                    <th>Customer Shipping Address2</th>
                                    <th>Customer Shipping City</th>
                                    <th>Customer Shipping State</th>
                                    <th>Customer Shipping Country</th>
                                    <th>Customer Shipping Pincode</th>
                                    <th>Customer Shipping GST No</th>
                                    <th>Customer Shipping PAN No</th>
                                    <th>Part No</th>
                                    <th>Part Desc</th>
                                    <th>HSN/SAC Code</th>
                                    <th>Customer PO NO</th>
                                    <th>Customer LINE NO</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Unit Rate</th>
                                    <th>Packing Charge (%)</th>
                                    <th>CGST (%)</th>
                                    <th>SGST (%)</th>
                                    <th>IGST (%)</th>
                                    <th>TCS (%)</th>
                                    <th>Packing Charge Amount</th>
                                    <th>CGST Amount</th>
                                    <th>SGST Amount</th>
                                    <th>IGST Amount</th>
                                    <th>TCS Amount</th>
                                    <th>Basic Amount</th>
                                    <th>Total Amount(Rs)</th>
                                    <th>Total Weight(KG)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoiceDatas as $invoiceData)
                                <tr>

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$invoiceData->rcmaster->rc_id}}</td>
                                    <td>{{date('d-m-Y', strtotime($invoiceData->invoice_date))}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_code}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_name}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_address}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_address1}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_city}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_state}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_country}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_pincode}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_gst_number}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->cus_pan_no}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_name}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_address}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_address1}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_city}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_state}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_country}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_pincode}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_gst_number}}</td>
                                    <td>{{$invoiceData->customerproductmaster->customermaster->delivery_cus_pan_no}}</td>
                                    <td>{{$invoiceData->productmaster->part_no}}</td>
                                    <td>{{$invoiceData->productmaster->part_desc}}</td>
                                    <td>{{$invoiceData->customerproductmaster->part_hsnc}}</td>
                                    <td>{{$invoiceData->customerpomaster->cus_po_no}}</td>
                                    <td>{{$invoiceData->customerpomaster->cus_po_item_no}}</td>
                                    <td>{{$invoiceData->qty}}</td>
                                    <td>{{$invoiceData->uom_masters->name}}</td>
                                    <td>{{($invoiceData->customerpomaster->rate)/($invoiceData->customerpomaster->part_per)}}</td>
                                    <td>{{$invoiceData->packing_charge}}</td>
                                    <td>{{$invoiceData->cgst}}</td>
                                    <td>{{$invoiceData->sgst}}</td>
                                    <td>{{$invoiceData->igst}}</td>
                                    <td>{{$invoiceData->tcs}}</td>
                                    <td>{{$invoiceData->packing_charge_amt}}</td>
                                    <td>{{$invoiceData->cgstamt}}</td>
                                    <td>{{$invoiceData->sgstamt}}</td>
                                    <td>{{$invoiceData->igstamt}}</td>
                                    <td>{{$invoiceData->tcsamt}}</td>
                                    <td>{{$invoiceData->basic_value}}</td>
                                    <td>{{$invoiceData->invtotal}}</td>
                                    <td></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="15" align="center">No Records Found!</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
