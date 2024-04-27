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
        }
        a{
            text-decoration:none !important;
        }
        #page-size {
            page-break-after: always;
        }
        @page {
            size: 10.41cm*10.16cm !important;
        }
        table {
            border-collapse: collapse;
            border-spacing:0.2px;
            min-height: 3.3955in !important;
            min-width: 3.7in !important;
        }   th, td {
            text-align:center;
            border:1px solid black;
            padding:0px;
        }
    </style>
    @stack('styles')
</head>
<body>
    @foreach ($grn_qc_datas as $grn_qc_data)
    <div class="grnprint">
        <div class="container-fluid">
            <div class="col-12">
                <div class="row" style="margin-top:6px!important">
                    <div class="col-12">
                        <h6 style="font-size:10px!important;font-color:black;text-align:center;"><b>VENKATESWARA STEELS & SPRING (I) PVT LTD (UNIT-I)</b></h6>
                        <h6 style="font-size:10px!important;font-color:black;text-align:center;" class="mx-auto"><b>GRN APPROVAL</b></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table">
                            <table >
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">DESCRIPTION</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->grn_data->poproduct->supplier_products->material->name}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">INV NO</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->grn_data->invoice_number}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">WEIGHT</th>
                                    @if ($grn_qc_data->status==1)
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->approved_qty}} {{$grn_qc_data->grn_data->poproduct->uom_datas->name}}</th>
                                    @elseif ($grn_qc_data->status==3)
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->onhold_qty}} {{$grn_qc_data->grn_data->poproduct->uom_datas->name}}</th>
                                    @else
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->rejected_qty}} {{$grn_qc_data->grn_data->poproduct->uom_datas->name}}</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">COIL NO</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->heat_no_data->coil_no}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">HEAT NO</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->heat_no_data->heatnumber}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">SUPPLIER</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->grn_data->poproduct->suppliers->name}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">GIN NO</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->grn_data->rcmaster->rc_id}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">STATUS</th>
                                    @if ($grn_qc_data->status==1)
                                    <th style="font-size:10px!important;font-color:black;">APPROVED</th>
                                    @elseif ($grn_qc_data->status==3)
                                    <th style="font-size:10px!important;font-color:black;">ON-HOLD</th>
                                    @else
                                    <th style="font-size:10px!important;font-color:black;">REJECTION</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">DATE</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->inspected_date}}</th>
                                </tr>
                                <tr>
                                    <th style="font-size:10px!important;font-color:black;">INSP BY</th>
                                    <th style="font-size:10px!important;font-color:black;">{{$grn_qc_data->inspected_user->name}}</th>
                                </tr>
                                <tr>
                                    @if ($grn_qc_data->status==1)
                                    <th style="font-size:17px!important;font-color:black;margin:auto;text-align:center;">G</th>
                                    @elseif ($grn_qc_data->status==3)
                                    <th style="font-size:17px!important;font-color:black;margin:auto;text-align:center;">S</th>
                                    @else
                                    <th style="font-size:17px!important;font-color:black;margin:auto;text-align:center;">R</th>
                                    @endif
                                    <th style="font-size:10px!important;font-color:black;margin:auto;text-align:center;">{{QrCode::size(90)->style('round')->generate($grn_qc_data->id)}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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
