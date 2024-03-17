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
                                            <td class="tg-amwm" colspan="14" style="font-weight:bold;text-align:center;vertical-align:top">Sulur,Coimbatore - 641 402. Ph.No. 0422 2680840 , 9659877955</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">GSTIN: 33AACCV3065F1ZL</td>
                                            <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">MODE OF TRANSPORT</td>
                                            <td class="tg-9hbo" style='font-weight:bold;vertical-align:top' colspan="12">{{$dc_transactionDatas[0]->trans_mode}}</td>
                                          </tr>
                                          <tr>
                                            <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">DC NUMBER</td>
                                            <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">VEHICLE NUMBER</td>
                                            <td class="tg-yw4l" style="vertical-align:top" colspan="12">{{$dc_transactionDatas[0]->vehicle_no}}</td>
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
                                            <td class="tg-yw4l" style="vertical-align:top" colspan="12">Coimbatore</td>
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
                                            <td colspan="13">{{$dc_transactionDatas[0]->supplier_address.$dc_transactionDatas[0]->supplier_address1.$dc_transactionDatas[0]->supplier_city.'-'.$dc_transactionDatas[0]->supplier_pincode}}</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State:</td>
                                            <td colspan="13">{{$dc_transactionDatas[0]->supplier_state}}</td>
                                          </tr>
                                          <tr>
                                            <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State code:</td>
                                            <td colspan="13">{{$dc_transactionDatas[0]->supplier_state_code}}</td>
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
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">HSN Code</td>
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Quantity</td>
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">UOM</td>
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Unit Rate</td>
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Total Value</td>
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Weight</td>
                                            <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="6">Remarks</td>
                                        </tr>
                                          <?php
                                          if ($count<=10) {
                                              $count1=$count;
                                              $diff=(10-$count);
                                              $first=$count-1;
                                          }else{
                                              $count1=10;
                                              $diff=0;
                                              $first=0;
                                          }
                                          ?>
                                          @for ($i = 0; $i < $count1; $i++)
                                          <tr>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$i+1}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->dc_no}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->issue_date}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->part_no}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->hsnc}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->issue_qty}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->uom}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->unit_rate}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->total_rate}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$i]->issue_wt}}</td>
                                              <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top" colspan="6">{{$dc_transactionDatas[$i]->total_rate}}</td>
                                          </tr>
                                          @endfor
                                            @if ($diff>0)
                                                @for ($x = $first; $x < (($diff)+1); $x++)
                                                    <tr >
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$x+2}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top" colspan="6"></td>
                                                    </tr>
                                                @endfor
                                                @else
                                            @endif
                                            <?php
                                            if ($count<=10) {
                                            ?>
                                                    <tr>
                                                        <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="5">TOTAL</td>
                                                        <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_qty}}</td>
                                                        <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="2"></td>
                                                        <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_rate}}</td>';
                                                        <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="7"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="16">TOTAL VALUE IN WORDS</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-yw4l" style="vertical-align:top;text-align:center;" colspan="16">{{$a}}</td>
                                                    </tr>
                                            <?php
                                            }else{
                                                echo "<tr><td colspan='16'>";
                                                echo "<br>";
                                                echo "</td></tr>";
                                            }
                                            ?>
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
                                                        <li>Material sent for {{$dc_transactionDatas[0]->operation_desc}} work only</li>
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
    <?php
    if ($count>10) {
        ?>
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
                                                    <td class="tg-amwm" colspan="14" style="font-weight:bold;text-align:center;vertical-align:top">Sulur,Coimbatore - 641 402. Ph.No. 0422 2680840 , 9659877955</td>
                                                  </tr>
                                                  <tr>
                                                    <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">GSTIN: 33AACCV3065F1ZL</td>
                                                    <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">MODE OF TRANSPORT</td>
                                                    <td class="tg-9hbo" style='font-weight:bold;vertical-align:top' colspan="12">{{$dc_transactionDatas[0]->trans_mode}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">DC NUMBER</td>
                                                    <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">VEHICLE NUMBER</td>
                                                    <td class="tg-yw4l" style="vertical-align:top" colspan="12">{{$dc_transactionDatas[0]->vehicle_no}}</td>
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
                                                    <td class="tg-yw4l" style="vertical-align:top" colspan="12">Coimbatore</td>
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
                                                    <td colspan="13">{{$dc_transactionDatas[0]->supplier_address.$dc_transactionDatas[0]->supplier_address1.$dc_transactionDatas[0]->supplier_city.'-'.$dc_transactionDatas[0]->supplier_pincode}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State:</td>
                                                    <td colspan="13">{{$dc_transactionDatas[0]->supplier_state}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State code:</td>
                                                    <td colspan="13">{{$dc_transactionDatas[0]->supplier_state_code}}</td>
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
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">HSN Code</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Quantity</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">UOM</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Unit Rate</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Total Value</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Weight</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="6">Remarks</td>
                                                    </tr>
                                                    <?php
                                                    if ($count<=20) {
                                                        $count2=$count;
                                                        $diff2=(20-$count);
                                                        $first2=$count-1;
                                                    }else{
                                                        $count1=20;
                                                        $diff2=0;
                                                        $first2=0;
                                                    }
                                                    ?>
                                                    @for ($y = 11; $y < $count2; $y++)
                                                    <tr>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$y+1}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->dc_no}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->issue_date}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->part_no}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->hsnc}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->issue_qty}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->uom}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->unit_rate}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->total_rate}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$y]->issue_wt}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top" colspan="6">{{$dc_transactionDatas[$y]->total_rate}}</td>
                                                    </tr>
                                                    @endfor
                                                    @if ($diff2>0)
                                                        @for ($z = $first2; $z < (($diff2)+1); $z++)
                                                            <tr>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$z+2}}</td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top" colspan="6"></td>
                                                            </tr>
                                                        @endfor
                                                        @else
                                                    @endif
                                                    <?php
                                                    if ($count<=20) {
                                                    ?>
                                                            <tr>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="5">TOTAL</td>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_qty}}</td>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="2"></td>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_rate}}</td>';
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="7"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="16">TOTAL VALUE IN WORDS</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tg-yw4l" style="vertical-align:top;text-align:center;" colspan="16">{{$a}}</td>
                                                            </tr>
                                                    <?php
                                                    }else{
                                                        echo "<tr><td colspan='16'>";
                                                        echo "<br>";
                                                        echo "</td></tr>";
                                                    }
                                                    ?>

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
                                                                <li>Material sent for {{$dc_transactionDatas[0]->operation_desc}} work only</li>
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
        <?php
    }
    ?>
        <?php
        if ($count>20) {
            ?>
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
                                                        <td class="tg-amwm" colspan="14" style="font-weight:bold;text-align:center;vertical-align:top">Sulur,Coimbatore - 641 402. Ph.No. 0422 2680840 , 9659877955</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">GSTIN: 33AACCV3065F1ZL</td>
                                                        <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">MODE OF TRANSPORT</td>
                                                        <td class="tg-9hbo" style='font-weight:bold;vertical-align:top' colspan="12">{{$dc_transactionDatas[0]->trans_mode}}</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="tg-amwm" colspan="2" style="font-weight:bold;text-align:center;vertical-align:top">DC NUMBER</td>
                                                        <td class="tg-l2oz" style="font-weight:bold;text-align:right;vertical-align:top" colspan="2">VEHICLE NUMBER</td>
                                                        <td class="tg-yw4l" style="vertical-align:top" colspan="12">{{$dc_transactionDatas[0]->vehicle_no}}</td>
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
                                                        <td class="tg-yw4l" style="vertical-align:top" colspan="12">Coimbatore</td>
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
                                                        <td colspan="13">{{$dc_transactionDatas[0]->supplier_address.$dc_transactionDatas[0]->supplier_address1.$dc_transactionDatas[0]->supplier_city.'-'.$dc_transactionDatas[0]->supplier_pincode}}</td>
                                                      </tr>
                                                      <tr>
                                                        <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State:</td>
                                                        <td colspan="13">{{$dc_transactionDatas[0]->supplier_state}}</td>
                                                      </tr>
                                                      <tr>
                                                        <td style='font-weight:bold;text-align:right;vertical-align:top' colspan="3">State code:</td>
                                                        <td colspan="13">{{$dc_transactionDatas[0]->supplier_state_code}}</td>
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
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">HSN Code</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Quantity</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">UOM</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Unit Rate</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Total Value</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">Weight</td>
                                                        <td  class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="6">Remarks</td>
                                                    </tr>
                                                    <?php
                                                    if ($count<=30) {
                                                        $count3=$count;
                                                        $diff3=(30-$count);
                                                        $first2=$count-1;
                                                    }else{
                                                        $count1=30;
                                                        $diff3=0;
                                                        $first2=0;
                                                    }
                                                    ?>
                                                    @for ($k = 21; $k < $count3; $k++)
                                                    <tr style="padding:20px">
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$k+1}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->dc_no}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->issue_date}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->part_no}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->hsnc}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->issue_qty}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->uom}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->unit_rate}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->total_rate}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$dc_transactionDatas[$k]->issue_wt}}</td>
                                                        <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top" colspan="6">{{$dc_transactionDatas[$k]->total_rate}}</td>
                                                    </tr>
                                                    @endfor
                                                    @if ($diff3>0)
                                                        @for ($l = $first2; $l < (($diff3)+1); $l++)
                                                            <tr>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top">{{$l+2}}</td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top"></td>
                                                                <td class="tg-baqh" style="text-align:center;height: 28px;vertical-align:top" colspan="6"></td>
                                                            </tr>
                                                        @endfor
                                                        @else
                                                    @endif
                                                    <?php
                                                    if ($count<=30) {
                                                    ?>
                                                            <tr>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="5">TOTAL</td>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_qty}}</td>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="2"></td>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top">{{$totalData[0]->sum_rate}}</td>';
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="7"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tg-amwm" style="font-weight:bold;text-align:center;vertical-align:top" colspan="16">TOTAL VALUE IN WORDS</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tg-yw4l" style="vertical-align:top;text-align:center;" colspan="16">{{$a}}</td>
                                                            </tr>
                                                    <?php
                                                    }else{
                                                        echo "<tr><td colspan='16'>";
                                                        echo "<br>";
                                                        echo "</td></tr>";
                                                    }
                                                    ?>
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
                                                                    <li>Material sent for {{$dc_transactionDatas[0]->operation_desc}} work only</li>
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
            <?php
        }
        ?>
</body>
</html>
