<?php
    $whole = floor($totalData[0]->sum_rate);
    $fraction = $totalData[0]->sum_rate - $whole;
    $fraction=$fraction*100;
    $rup=ROUND($fraction);
    $pai=floor($totalData[0]->sum_rate);
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

    <!-- Main styles for this application-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{asset('css/examples.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/toaster.min.css')}}" />
    <style>
        a{
            text-decoration:none !important;
        }
        .header-sticky{
            background-color:currentColor !important;
        }
        table, td, th {
        border: 1px solid black;
        text-align:left;
        }
        table, td {
        font-family:Arial, sans-serif;
        font-size:12px;padding:3px 3px;
        border-style:solid;
        border-width:1px;
        overflow:hidden;
        word-break:normal;
        }
        table, th {
        font-family:Arial, sans-serif;
        font-size:16px;font-weight:normal;
        padding:1px 3px;
        border-style:solid;
        border-width:1px;
        overflow:hidden;
        word-break:normal;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        border-spacing:0;margin:0px auto;
        }

@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}
    </style>
    @stack('styles')

  </head>
<body>
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="col-12">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="table">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-responsive">
                                        <tr>
                                            <th class="tg-bn4o" colspan="16" style="font-weight:bold;font-size:14px;text-align:center!important;vertical-align:top"> DELIVERY CHALLAN</th>
                                          </tr>
                                          <tr>
                                            <td class="tg-3b15" colspan="2" rowspan="3"><img src="{{asset('image/logo.png')}}" alt="Mountain View" style="width:100%;height:8%;background-color:#010066;vertical-align:center"></img></td>
                                            <td class="tg-bn4o" colspan="14" style="font-weight:bold;font-size:14px;text-align:center!important;vertical-align:top">VENKATESWARA STEELS AND SPRINGS (INDIA) PVT LTD</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" colspan="14" style="font-weight:bold;text-align:center;vertical-align:top">1/89 Ravuthur Pirivu, Kannampalayam.</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" colspan="14" style="font-weight:bold;text-align:center;vertical-align:top">Sulur Coimbatore 641 402 Ph.No. 0422 2680840 , 9659877955</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">GSTIN: 33AACCV3065F1ZL</td>
                                            <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">MODE OF TRANSPORT</td>
                                            <td class="tg-9hbo" style='font-weight:bold;vertical-align:top' colspan="12">{{$dc_transactionDatas[0]->s_no}}</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">DC NUMBER</td>
                                            <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">VEHICLE NUMBER</td>
                                            <td class="tg-yw4l" style="vertical-align:top" colspan="12">{{$dc_transactionDatas[0]->s_no}}</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-ujoh" style="font-weight:bold;font-size:22px;text-align:center;vertical-align:top" colspan="2">{{'DCU1-'.$dc_transactionDatas[0]->s_no}}</td>
                                            <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">DATE AND TIME OF SUPPLY</td>
                                            <td class="tg-yw4l" style="vertical-align:top" colspan="12">{{date('d-m-Y  # H:i')}}</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">DATE:</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{date('d-m-Y')}}</td>
                                            <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">PLACE OF SUPPLY</td>
                                            <td class="tg-yw4l" style="vertical-align:top" colspan="12"></td>
                                          </tr>
                                          <tr>
                                            <td class="tg-bn4o" colspan="16" style="font-weight:bold;font-size:14px;text-align:center!important;vertical-align:top">DETAILS OF THE RECEIVER</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">Name:</td>
                                            <td colspan="13">{{$dc_transactionDatas[0]->supplier_name}}</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">Address:</td>
                                            <td colspan="13">{{$dc_transactionDatas[0]->supplier_address}}</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State:</td>
                                            <td colspan="13">TAMIL NADU</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State code:</td>
                                            <td colspan="13">33</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">GST Unique ID:</td>
                                            <td colspan="13">{{$dc_transactionDatas[0]->supplier_gst_number}}</td>
                                          </tr>
                                            <tr>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">S No</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">DC Number</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">DC Date</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Part No</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Quantity</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">UOM</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Unit Rate</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Total Value</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Weight</td>
                                                <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="7">Remarks</td>
                                            </tr>
                                            @foreach ($dc_transactionDatas as $dc_transactionData)
                                                <tr>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$loop->iteration}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->dc_no}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_date}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->part_no}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_qty}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->uom}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->unit_rate}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->total_rate}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_wt}}</td>
                                                    <td class="tg-baqh" style="text-align:center;vertical-align:top" colspan="7">{{$dc_transactionData->total_rate}}</td>
                                                </tr>
                                            @endforeach
                                            @foreach ($dc_transactionDatas as $dc_transactionData)
                                            <tr>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$loop->iteration}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->dc_no}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_date}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->part_no}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_qty}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->uom}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->unit_rate}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->total_rate}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_wt}}</td>
                                                <td class="tg-baqh" style="text-align:center;vertical-align:top" colspan="7">{{$dc_transactionData->total_rate}}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($dc_transactionDatas as $dc_transactionData)
                                        <tr>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$loop->iteration}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->dc_no}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_date}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->part_no}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_qty}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->uom}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->unit_rate}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->total_rate}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_wt}}</td>
                                            <td class="tg-baqh" style="text-align:center;vertical-align:top" colspan="7">{{$dc_transactionData->total_rate}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($dc_transactionDatas as $dc_transactionData)
                                    <tr>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$loop->iteration}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->dc_no}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_date}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->part_no}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_qty}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->uom}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->unit_rate}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->total_rate}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_wt}}</td>
                                        <td class="tg-baqh" style="text-align:center;vertical-align:top" colspan="7">{{$dc_transactionData->total_rate}}</td>
                                    </tr>
                                @endforeach
                                @foreach ($dc_transactionDatas as $dc_transactionData)
                                <tr>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$loop->iteration}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->dc_no}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_date}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->part_no}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_qty}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->uom}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->unit_rate}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->total_rate}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top">{{$dc_transactionData->issue_wt}}</td>
                                    <td class="tg-baqh" style="text-align:center;vertical-align:top" colspan="7">{{$dc_transactionData->total_rate}}</td>
                                </tr>
                            @endforeach

                                            <tr>
                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="4">TOTAL</td>
                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_qty}}</td>
                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="2"></td>
                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_rate}}</td>';
                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="8"></td>
                                              </tr>
                                              <tr>
                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="16">TOTAL VALUE IN WORDS</td>
                                              </tr>
                                              <tr>
                                                <td class="tg-yw4l" style="vertical-align:top;text-align:center;" colspan="16">{{$a}}</td>
                                              </tr>

                                            <tr>
                                                <td class="tg-9hbo" style='font-weight:bold;vertical-align:top' colspan="8">
                                                Terms & Conditions :
                                                    <ul>
                                                        <li>Not For Supply</li>
                                                        @if ($dc_transactionDatas[0]->operation=='FG For S/C')
                                                        <li>Inter Unit Transfer</li>
                                                        @else
                                                        <li>For Job Work</li>
                                                        @endif
                                                        <li></li>
                                                    </ul>
                                                </td>
                                                <td class="tg-9hbo" style='font-weight:bold;vertical-align:top' colspan="8">For Venkateswara Steels &amp; Springs India Pvt Ltd            </td>
                                            </tr>
                                            <tr>
                                                <td class="tg-yw4l" style="vertical-align:top" colspan="16" rowspan="0"><br>RECEIVED,THE ABOVE GOODS<br><br>CUSTOMER SIGNATURE<br>.</td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>
