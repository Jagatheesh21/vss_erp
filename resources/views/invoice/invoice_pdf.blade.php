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
        .logo_table{
            border:none;
        }
        table.row2{
            border: 1px solid black;
            border-radius: 10%;
            border-collapse: collapse;
            width: 100%;
            border-spacing:0;margin:0px auto;
        }
        table.row3{
            border: 1px solid black;
            border-radius: 10%;
            border-collapse: collapse;
            width: 100%;
            border-spacing:0;margin:0px auto;
        }
        table.row4{
            border: 1px solid black;
            border-radius: 10%;
            border-collapse: collapse;
            width: 100%;
            border-spacing:0;margin:0px auto;
        }


        h3.tax{
            display: inline;
            border: 1px solid black;
            border-radius: 5px;
            background-color: #9eaec2;
            align-items: center;
            align-content: center;
            width: 21%;
            height: 25%;
            margin-left: 16rem;
        }
        h6.type{
            padding-left: 190px;
            display: inline;
            text-align: end;
        }

        table, td {
        font-family:Arial, sans-serif;
        font-size:12px;
        padding:3px 3px;
        overflow:hidden;
        word-break:normal;
        }
        table, th {
        font-family:Arial, sans-serif;
        font-size:16px;
        font-weight:normal;
        padding:0px 0px;
        overflow:hidden;
        word-break:normal;
        }
        ul.a {list-style-type: none;
            border: none;
            display: inline;
        }
        ul.b {list-style-type: none;
            border: none;
            display: inline;
        }
    li.a1{
        border: 1px solid black;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        width: 150px;
    }
    li.a2{
        border: 1px solid black;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        width: 150px;

    }
    .item1 { grid-area: header; }
.item2 { grid-area: menu; }
.item3 { grid-area: main; }
.item4 { grid-area: right; }
.item5 { grid-area: footer; }

.grid-container {
  display: grid;
  grid-template:
    'header header header header header header'
    'menu main main main right right'
    'menu footer footer footer footer footer';
  grid-gap: 10px;
  background-color: #2196F3;
  padding: 10px;
}

.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}

        /* @media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}} */
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
                            <h3 class="tax">&nbsp;TAX INVOICE</h3>
                            <h6 class="type">Original Invoice</h6>
                            <br>
                            <div class="table">
                                <table class="logo_table">
                                    <tr>
                                        <td colspan="2" rowspan="4" class="logo_table"><img src="{{asset('image/fav_icon.png')}}" alt="Mountain View" style="width:60%;height:7%;background-color:#086cdd;vertical-align:center"></img></td>
                                        <td class="tg-bn4o" colspan="12" class="logo_table" style="font-weight:bold;font-size:17px;text-align:center!important;vertical-align:top">VENKATESWARA STEELS AND SPRINGS (INDIA) PVT LTD</td>
                                        <td colspan="2" rowspan="4" class="logo_table"><img src="data:image/png;base64,{{ base64_encode($qrCodes) }}" alt="QR Code"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-amwm logo_table" colspan="10" style="font-size:14px;text-align:left;vertical-align:top">1/89-6 Ravathur Pirivu, Kannampalayam, Sulur, Coimbatore-641402.</td>
                                    </tr>
                                    <tr>
                                        <td class="tg-amwm logo_table" colspan="10" style="font-size:14px;text-align:left;vertical-align:top">Tel : 0422-2680840 ; mail : info@venkateswarasteels.com</td>
                                    </tr>
                                    <tr>
                                        <td class="tg-amwm logo_table" colspan="10" style="font-size:14px;text-align:left;vertical-align:top">PAN : AACCV3065F ; GST : 33AACCV3065F1ZL</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="col-3">
                <ul class="a">
                    <li class="a1"><b>INVOICE NUMBER</b></li>
                    <li class="a2">U12425-00762</li>
                </ul>
            </div>
            <div class="col-3">
                <ul class="b">
                    <li class="a1"><b>INVOICE NUMBER</b></li>
                    <li class="a2">U12425-00762</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="grid-container">
        <div class="item1">Header</div>
        <div class="item2">Menu</div>
        <div class="item3">Main</div>
        <div class="item4">Right</div>
        <div class="item5">Footer</div>
      </div>

@push('scripts')
<script>

    function downloadSVG() {
      const svg = document.getElementById('container').innerHTML;
      const blob = new Blob([svg.toString()]);
      const element = document.createElement("a");
      element.download = "w3c.svg";
      element.href = window.URL.createObjectURL(blob);
      element.click();
      element.remove();
    }
    </script>
@endpush
</body>
</html>
