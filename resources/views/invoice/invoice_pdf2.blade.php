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
            font-family:Arial, sans-serif;
        }
        a{
            text-decoration:none !important;
        }
        ul {list-style-type: none;
            border: none;
            font-size: 15px!important;
        }
        li{
            font-size: 13px;
            font-color:black;
        }

    </style>
    @stack('styles')
</head>
<body>

        <div class="row mt-3">
            <div class="col-8">
                <button style="margin-left: 300px" type="button" class="btn btn-secondary text-dark">TAX INVOICE</button>
            </div>
            <div class="col-3 mt-2">
                <p style="margin-left: 50px" class="text-start"><b>Accounts Invoice</b></p>
            </div>
        </div>
        <div class="row mt-1">
            <div class="container  d-flex">
                <div class="col-1">
                    <img src="{{asset('image/fav_icon.png')}}" style="margin-left: 30px" alt="" srcset="">
                </div>
                <div class="col-8">
                    <ul>
                        <li><h6><b>VENKATESWARA STEELS & SPRINGS (INDIA) PVT LTD</b></h6></li>
                        <li>1/89-6 Ravathur Pirivu, Kannampalayam, Sulur, Coimbatore-641402</li>
                        <li>Tel : 0422-2680840 ; mail : info@venkateswarasteels.com</li>
                        <li>PAN : AACCV3065F ; GST : 33AACCV3065F1ZL</li>
                    </ul>
                </div>
                <div class="col-2">
                    {{$qrCodes}}
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
