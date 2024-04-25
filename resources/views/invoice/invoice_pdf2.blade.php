<?php
    $whole = floor($invoiceDatas->invtotal);
    $fraction = $invoiceDatas->invtotal - $whole;
    $fraction=$fraction*100;
    $rup=ROUND($fraction);
    $pai=floor($invoiceDatas->invtotal);
    $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    if($digit->format($rup)==""){
        $a=strtoupper($digit->format($pai))." ONLY";
        $amtstr=$a;
    }else{
        $a=strtoupper($digit->format($pai))." AND PAISE ".strtoupper($digit->format($rup)." ONLY");
    }
?>
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
            font-family:Arial;
            color: black;
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
        #tax_invoice{
            font-size: 16px!important;
            border: 1px solid black;
            border-radius: 10px;
            color: black !important;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-left: 300px;
            max-height: 40px;
        }
        #supplymentary_invoice{
            font-size: 14px!important;
            border: 1px solid black;
            border-radius: 10px;
            color: black !important;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-left: 300px;
            max-height: 40px;
        }
        ul {list-style-type: none;
            border: none;
            font-size: 15px!important;
        }
        li{
            font-size: 13px;
            font-color:black;
        }
        #resultsTable {
        border: 1px solid black;
        border-radius: 15px !important;
        }
        ul.a {list-style-type: none;
            border: none;
        }
        ul.b {list-style-type: none;
            border: none;
        }
        ul.c {list-style-type: none;
            border: none;
        }
        li.a1{
            border: 1px solid black;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            width: 150px;
            text-align: center;
        }
        li.a2{
            border: 1px solid black;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            width: 150px;
            text-align: center;
        }
        li.a3{
            border: 1px solid black;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            min-width: 350px;
            text-align: center;
        }
        li.a4{
            border: 1px solid black;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            min-width: 350px;
            min-height: 70px;
            max-height: 70px;
            text-align: center;
        }
        li.a5{
            border: 1px solid black;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            width: 220px;
            text-align: center;
        }
        li.a6{
            border: 1px solid black;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            min-width: 220px;
            min-height: 70px;
            max-height: 70px;
            text-align: center;
        }

    </style>
    @stack('styles')
</head>
<body>
    @for ($i = 0; $i < $page_count; $i++)
        <div id="page-size">
            <div class="row mt-3" style="max-height: 50px;">
                <div class="col-8">
                    @if ($invoiceDatas->sup==1)
                        <button type="button" id="supplymentary_invoice" class="btn text-dark"><b>SUPPLEMENTARY INVOICE</b></button>
                    @else
                        <button type="button" id="tax_invoice" class="btn text-dark"><b>TAX INVOICE</b></button>
                    @endif
                </div>
                <div class="col-3 mt-2">
                    @if ($i==0)
                        <p style="margin-left: 75px;font-size:14px;margin-top:15px;" class="text-start"><b>Original Invoice</b></p>
                    @elseif ($i==1)
                        <p style="margin-left: 75px;font-size:14px;margin-top:15px;" class="text-start"><b>Transport Copy</b></p>
                    @elseif ($i==2)
                        <p style="margin-left: 85px;font-size:14px;margin-top:15px;" class="text-start"><b>Extra Copy</b></p>
                    @elseif ($i==3)
                        <p style="margin-left: 75px;font-size:14px;margin-top:15px;" class="text-start"><b>Accounts Copy</b></p>
                    @else

                    @endif
                </div>
            </div>
            <div class="row mt-1">
                <div class="container  d-flex">
                    <div class="col-2">
                        <img src="{{asset('image/fav_icon.png')}}" style="margin-left: 60px;width:50%;height:78%;margin-top:3px;" alt="" srcset="">
                    </div>
                    <div class="col-7">
                        <ul>
                            <li><h6><b>VENKATESWARA STEELS & SPRINGS (INDIA) PVT LTD</b></h6></li>
                            <li>1/89-6 Ravathur Pirivu, Kannampalayam, Sulur, Coimbatore-641402</li>
                            <li>Tel : 0422-2680840 ; mail : info@venkateswarasteels.com</li>
                            <li>PAN : AACCV3065F ; GST : 33AACCV3065F1ZL</li>
                        </ul>
                    </div>
                    <div class="col-2 mx-auto">
                        <span>{{$qrCodes}}</span>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-11  d-flex">
                    <div class="col-3">
                        <ul class="a">
                            <li class="a1"><b>INVOICE NUMBER</b></li>
                            @if ($invoiceDatas->rcmaster->rc_id!='')
                                <li class="a2">{{$invoiceDatas->rcmaster->rc_id}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="b">
                            <li class="a1"><b>INVOICE DATE / TIME</b></li>
                            @if ($invoiceDatas->invoice_date!='')
                                <li class="a2">{{date('d-m-Y', strtotime($invoiceDatas->invoice_date))}} @ {{$invoiceDatas->invoice_time}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="c">
                            <li class="a1"><b>VENDOR CODE</b></li>
                            @if ($invoiceDatas->customerproductmaster->customermaster->supplier_vendor_code!='')
                                <li class="a2">{{$invoiceDatas->customerproductmaster->customermaster->supplier_vendor_code}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="d">
                            <li class="a1"><b>PO NUMBER</b></li>
                            @if ($invoiceDatas->customerpomaster->cus_po_no!='')
                                <li class="a2">{{$invoiceDatas->customerpomaster->cus_po_no}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-11  d-flex">
                    <div class="col-3">
                        <ul class="a">
                            <li class="a1"><b>PO DATE</b></li>
                            @if ($invoiceDatas->customerpomaster->cus_po_date!='')
                                <li class="a2">{{date('d-m-Y', strtotime($invoiceDatas->customerpomaster->cus_po_date))}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="b">
                            <li class="a1"><b>LINE NO</b></li>
                            @if ($invoiceDatas->customerpomaster->cus_po_item_no!='')
                                <li class="a2">{{$invoiceDatas->customerpomaster->cus_po_item_no}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="c">
                            <li class="a1"><b>EWAY BILL</b></li>
                            <li class="a2">COPY ATTACHED</li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="d">
                            <li class="a1"><b>PAN NO</b></li>
                            @if ($invoiceDatas->customerproductmaster->customermaster->cus_pan_no!='')
                                <li class="a2">{{$invoiceDatas->customerproductmaster->customermaster->cus_pan_no}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <ul>
                                <li style="font-size: 12px!important"><b>DELIVERY ADDRESS :</b></li>
                                <li style="font-size: 12px!important"><b>{{$invoiceDatas->customerproductmaster->customermaster->cus_name}},</b></li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->cus_address}},</li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->cus_address1}},</li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->cus_city}},</li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->cus_state}} - {{$invoiceDatas->customerproductmaster->customermaster->cus_pincode}}.</li>
                                <li style="font-size: 12px!important">GSTIN : {{$invoiceDatas->customerproductmaster->customermaster->cus_gst_number}}</li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li style="font-size: 12px!important"><b>BILLING ADDRESS :</b></li>
                                <li style="font-size: 12px!important"><b>{{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_name}},</b></li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_address}},</li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_address1}},</li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_city}},</li>
                                <li style="font-size: 12px!important">{{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_state}} - {{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_pincode}}.</li>
                                <li style="font-size: 12px!important">GSTIN : {{$invoiceDatas->customerproductmaster->customermaster->delivery_cus_gst_number}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="col-11 mx-auto">
                        <div class="table-responsive">
                            <table class="table table-bordered border-dark" style="min-height:400px;max-height:400px;">
                                <thead>
                                    <tr style="font-family: arial;font-size:11px;text-align:center;color:black;font-weight:10px;vertical-align: top;">
                                        <td><b>S.No</b></td>
                                        <td><b>PART NO / NAME / HSNC</b></td>
                                        <td><b>PRICE / PER</b></td>
                                        <td><b>QTY / UOM</b></td>
                                        <td><b>PACK / VALUE</b></td>
                                        <td><b>VALUE</b></td>
                                        <td><b>IGST / VALUE</b></td>
                                        <td><b>CGST / VALUE</b></td>
                                        <td><b>SGST / VALUE</b></td>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr style="font-family: arial;font-size:12px;text-align:left;color:black;">
                                        <td>1</td>
                                        <td>{{$invoiceDatas->productmaster->part_no}} <br>
                                            {{$invoiceDatas->productmaster->part_desc}} <br>
                                            {{$invoiceDatas->customerproductmaster->part_hsnc}}</td>
                                        <td>{{$invoiceDatas->part_rate}} <br>
                                            EACH</td>
                                        <td>{{$invoiceDatas->qty}} <br>{{$invoiceDatas->uom_masters->name}}</td>
                                        @if ($invoiceDatas->packing_charge!=0)
                                        <td>{{$invoiceDatas->packing_charge}} % <br>{{$invoiceDatas->packing_charge_amt}}</td>
                                        @else
                                        <td>0 % <br>0</td>
                                        @endif
                                        @if ($invoiceDatas->igst!=0)
                                        <td>{{$invoiceDatas->basic_value}}</td>
                                        <td>{{$invoiceDatas->igst}} % <br>{{$invoiceDatas->igstamt}}</td>
                                        <td>0 % <br>0</td>
                                        <td>0 % <br>0</td>
                                        @else
                                        <td>{{$invoiceDatas->basic_value}}</td>
                                        <td>0 % <br>0</td>
                                        <td>{{$invoiceDatas->cgst}} % <br>{{$invoiceDatas->cgstamt}}</td>
                                        <td> {{$invoiceDatas->sgst}} % <br>{{$invoiceDatas->sgstamt}}</td>
                                        @endif
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="font-family: arial;font-size:11px;text-align:left;color:black;">
                                        <td colspan="4">Rupees In Words : {{$a}}</td>
                                        <td><b>{{($invoiceDatas->packing_charge_amt)}}</b></td>
                                        <td><b>{{($invoiceDatas->basic_value)}}</b></td>
                                        <td><b>{{($invoiceDatas->igstamt)}}</b></td>
                                        <td><b>{{($invoiceDatas->cgstamt)}}</b></td>
                                        <td><b>{{($invoiceDatas->sgstamt)}}</b></td>
                                    </tr>
                                    <tr style="font-family: arial;font-size:14px;text-align:left;color:black;">
                                        <td colspan="6">  Declaration : We declare that this invoice shows the actual price of the
                                            goods and that all particulars are true and correct. </td>
                                        <td style="font-size: 16!important" colspan="2"><b>TOTAL VALUE</b></td>
                                        <td style="font-size: 16!important"><b>{{($invoiceDatas->invtotal)}}</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-11  d-flex">
                    <div class="col-3">
                        <ul class="a">
                            <li class="a1"><b>TRANS MODE</b></li>
                            @if ($invoiceDatas->trans_mode!='')
                                <li class="a2">{{($invoiceDatas->trans_mode)}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="b">
                            <li class="a1"><b>DISTANCE (Kms)</b></li>
                            @if ($invoiceDatas->customerproductmaster->customermaster->distance!='')
                                <li class="a2">{{($invoiceDatas->customerproductmaster->customermaster->distance)}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="c">
                            <li class="a1"><b>TRANSPORT NAME</b></li>
                            @if ($invoiceDatas->trans_name!='')
                                <li class="a2">{{($invoiceDatas->trans_name)}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="d">
                            <li class="a1"><b>VEHICLE NO</b></li>
                            @if ($invoiceDatas->vehicle_no!='')
                            <li class="a2">{{($invoiceDatas->vehicle_no)}}</li>
                            @else
                            <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-11  d-flex">
                    <div class="col-8">
                        <ul class="a">
                            <li class="a3" style="font-family: arial;font-size:11px;"><b>Remarks : ( If Any )</b></li>
                            @if ($invoiceDatas->remarks!='')
                                <li class="a4" style="font-family: arial;font-size:11px;">{{($invoiceDatas->remarks)}}</li>
                            @else
                                <li class="a4" style="font-family: arial;font-size:11px;">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="a">
                            <li class="a5" style="font-family: arial;font-size:11px;"><b>Authorised signatory( FOR VSSIPL)</b></li>
                            <li class="a6 d-flex" style="font-family: arial;font-size:11px;">
                                <img src="{{asset('image/e-sales4.png')}}" class="m-auto mt-1" width="70%" height="60%" alt="" srcset="">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <footer style="text-align: center;margin-bottom:10px;margin-top:50px;font-size:12px;">
                <p>Page {{($i+1)}}/{{$page_count}} </p>
            </footer>
        </div>
    @endfor


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
