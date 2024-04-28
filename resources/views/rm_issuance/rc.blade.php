<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="VSSIPL-ERP">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('assets/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{asset('vendors/simplebar/css/simplebar.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendors/simplebar.css')}}">
    <link  rel="stylesheet" href="{{asset('css/select2.min.css')}}" />
    <link  rel="stylesheet" href="{{asset('css/boxicons.min.css')}}" />

	{{-- <link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}"> --}}
    <!-- Main styles for this application-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{asset('css/examples.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/toaster.min.css')}}" />
    <style>
        body{
            font-family:Arial !important;
            color: black !important;
            border: 0px solid black;
            margin: 2%;
            padding: 0;
        }
        a{
            text-decoration:none !important;
        }
        #page-size {
            page-break-after: always;
        }
        @page {
            size: A4;
        }
        table {
            border-collapse: collapse;
            border-spacing:0px !important;
        }   th, td {
            text-align:center;
            border:1px solid black;
            padding:0px;
        }
        td{
            font-size: 10px!important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="row">
        <div class="container">
            <div class="col-12">
                <div class="col-12">
                    <div class="table-responsive mt-1 mx-1">
                        <table class="table table-bordered border-dark" style="line-height: 1;">
                            <tr>
                                <th colspan="8" class="me-auto text-center align-middle" style="text-align: center"><b>MASTER ROUTE CARD - VSSIPL - 1</b></th>
                                <th colspan="3">{{$qrCodes}}</th>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-dark"><b>MASTER ROUTE CARD #</b></td>
                                <td colspan="2" style="font-size: 20px;!important"><b>{{$d12Datas->current_rcmaster->rc_id}}</b></td>
                                <td class="text-dark"><b>Issue date</b></td>
                                <td colspan="2">{{date('d-m-Y', strtotime($d12Datas->open_date))}}</td>
                                <td  colspan="2"><b>Format.No</b></td>
                                <td><b>STR/R/09</b></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>PART NUMBER</b></td>
                                <td colspan="2"><b>{{$d12Datas->partmaster->child_part_no}}</b></td>
                                <td><b>Closing Date</b></td>
                                <td colspan="2"></td>
                                <td colspan="2"><b>Rev No / DATE</b></td>
                                <td colspan="1"><b>00 / 02.01.2017</b></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Size with Grade / Coil size</b></td>
                                <td colspan="4"><b>{{$d12Datas->rm_master->name}}</b></td>
                                <td><b>Coil No</b></td>
                                <td >{{$d12Datas->heat_nomaster->coil_no}}</td>
                                <td><b>Lot No</b></td>
                                <td>{{$d12Datas->heat_nomaster->lot_no}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Heat No</b></td>
                                <td colspan="2"><b>{{$d12Datas->heat_nomaster->heatnumber}}</b></td>
                                <td colspan="2"><b>RM.T.C Number</b></td>
                                <td colspan="4">{{$d12Datas->heat_nomaster->tc_no}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Manufacturer</b></td>
                                <td colspan="2"><b></b></td>
                                <td colspan="2"><b>Supplier Name</b></td>
                                <td colspan="4">{{$d12Datas->grndata->poproduct->suppliers->name}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Gin Number and Date</b></td>
                                <td colspan="2"><b>{{$d12Datas->grndata->rcmaster->rc_id}}</b></td>
                                <td >{{date('d-m-Y', strtotime($d12Datas->grndata->grndate))}}</td>
                                <td colspan="2"><b>Inv No & Date</b></td>
                                <td colspan="2"><b>{{$d12Datas->grndata->invoice_number}}</b></td>
                                <td colspan="1">{{date('d-m-Y', strtotime($d12Datas->grndata->invoice_date))}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>WORK ORDER QTY</b></td>
                                <td colspan="2"><b></b></td>
                                <td colspan="3"><b>REQUIRED WEIGHT IN KG</b></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Physical issue coil weight</b></td>
                                <td colspan="2"><b>{{$d12Datas->rm_issue_qty}}</b></td>
                                <td colspan="3"><b>Bal RETURN TO STORES WT</b></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3" rowspan="2"><b>Coil Loading Details</b></td>
                                <td colspan="2"><b>Date</b></td>
                                <td colspan="3"><b>Time</b></td>
                                <td><b>Shift</b></td>
                                <td colspan="3"><b>Total Running Hours</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="3"></td>
                                <td></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Department</b></td>
                                <td colspan="2"></td>
                                <td colspan="2"><b>Machine No</b></td>
                                <td colspan="2"></td>
                                <td colspan="1"><b>Group</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="11"><b>MATERIAL PROCESS DETAILS</b></td>
                            </tr>
                            <tr>
                                <td><b>S.No</b></td>
                                <td><b>MACHINE ID</b></td>
                                <td><b>DATE</b></td>
                                <td><b>SHIFT</b></td>
                                <td><b>OPERATOR</b></td>
                                <td><b>PART NUMBER</b></td>
                                <td><b>OK-(KGS)</b></td>
                                <td><b>R/W-(KGS)</b></td>
                                <td><b>SCRAP-(KGS)</b></td>
                                <td><b>FOREMAN SIGNATURE</b></td>
                                <td><b>RECEIVER SIGNATURE</b></td>
                            </tr>
                            @for ($i=1;$i<=10;$i++)
                            <tr>
                                <td>{{$i}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="6"><b>Total QTY</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6"><b>Total KG</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6"><b>Balance Coil Return To Stores (KG)</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>FOREMAN SIGN</b></td>
                                <td colspan="3"></td>
                                <td colspan="3"><b>STORES SIGN</b></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="7"><b>ROUTE CARD CLOSING DETAILS</b></td>
                                <td colspan="4"><b>STORES ALERT</b></td>
                            </tr>
                            <tr>
                                <td><b>DATE</b></td>
                                <td colspan="2"><b>CHILD RC NO</b></td>
                                <td><b>QTY ISSUE</b></td>
                                <td><b>KG ISSUE</b></td>
                                <td><b>RECEIVED</b></td>
                                <td><b>ISSUED BY</b></td>
                                <td colspan="4"><b>STOCK DETAIL EXCEPT THIS MRC</b></td>
                            </tr>
                            <tr style="height:0px!important;">
                                <td></td>
                                <td colspan="2"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3"><b>SF</b></td>
                                <td></td>
                            </tr>
                            <tr style="height:0px!important;">
                                <td></td>
                                <td colspan="2"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3"><b>WIP</b></td>
                                <td></td>
                            </tr>
                            <tr style="height:0px!important;">
                                <td></td>
                                <td colspan="2"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3"><b>FG</b></td>
                                <td></td>
                            </tr>
                            <tr style="height:0px!important;">
                                <td></td>
                                <td colspan="2"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3"><b>OUT SC</b></td>
                                <td></td>
                            </tr>
                            <tr style="height:0px!important;">
                                <td></td>
                                <td colspan="2"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3"><b>TOTAL</b></td>
                                <td></td>
                            </tr>
                            <tr style="height:0px!important;">
                                <td></td>
                                <td colspan="2"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="3"><b>RC VALID QUANTITY</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>PREPARED BY</b></td>
                                <td colspan="3"></td>
                                <td colspan="3"><b>RECEIVED BY</b></td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{asset('js/jquery.min.js')}}" ></script>
<script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/boxicons.js')}}"></script>
<script src="{{asset('js/toaster.min.js')}}" ></script>
<script>
setTimeout(() => {
$('.alert').alert('close');
}, 2000);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
@stack('scripts')
</html>
