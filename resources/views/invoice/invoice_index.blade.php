@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Invoice List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('invoicedetails.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>GRN Number</th>
                                    <th>GRN Date</th>
                                    <th>PO Number</th>
                                    <th>Supplier Code</th>
                                    <th>Supplier Name</th>
                                    <th>RM Category</th>
                                    <th>RM Description</th>
                                    <th>Total Inward Stock</th>
                                    <th>Total Incoming Quality Approved Stock</th>
                                    <th>Total Incoming Quality On Hold Stock</th>
                                    <th>Total Incoming Quality On Rejected Stock</th>
                                    <th>Total Production Issuance Stock</th>
                                    <th>Total RM Return Stock</th>
                                    <th>Total DC Issuance Stock</th>
                                    <th>Available Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="18" align="center">No Records Found!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/boxicons.js')}}"></script>
@endsection
