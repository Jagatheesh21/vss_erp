<?php
    $whole = floor($po_total);
    $fraction = $po_total - $whole;
    $fraction=$fraction*100;
    $rup=ROUND($fraction);
    $pai=floor($po_total);
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
        .policy{
            border: 1px solid black;
            margin: 3%;
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
            min-width: 80px;
            min-height: 40px;
            max-height: 40px;
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
            min-height: 40px;
            max-height: 40px;
            text-align: center;
        }

    </style>
    @stack('styles')
</head>
<body>
        <div id="page-size">
            <div class="row mt-2">
                <div class="container">
                    <p class="text-end" style="margin-right:45px!important;font-size:13px;margin-top:6px!important;"><b>Purchase Order(PUR/R/04)</b></p>
                </div>
                <div class="container  d-flex">
                    <div class="col-2">
                        <img src="{{asset('image/fav_icon.png')}}" style="margin-left: 60px;width:50%;height:72%;margin-top:3px;" alt="" srcset="">
                    </div>
                    <div class="col-7">
                        <ul>
                            <li style="font-size: 14px;"><b>VENKATESWARA STEELS & SPRINGS (INDIA) PVT LTD</b></li>
                            <li style="font-size: 12px;">1/89-6 Ravathur Pirivu, Kannampalayam, Sulur, Coimbatore-641402</li>
                            <li style="font-size: 12px;">Tel : 0422-2680840 ; mail : info@venkateswarasteels.com</li>
                            <li style="font-size: 12px;">PAN : AACCV3065F ; GST : 33AACCV3065F1ZL</li>
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
                            <li class="a1"><b>PO NUMBER</b></li>
                            @if ($po_datas->rcmaster->rc_id!='')
                                <li class="a2">{{$po_datas->rcmaster->rc_id}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="b">
                            <li class="a1"><b>PO DATE</b></li>
                            @if ($po_datas->podate!='')
                                <li class="a2">{{date('d-m-Y', strtotime($po_datas->podate))}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="c">
                            <li class="a1"><b>QUOTATION NO</b></li>
                            @if ($po_datas->quotno!='')
                                <li class="a2">{{$po_datas->quotno}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="d">
                            <li class="a1"><b>QUOTATION DATE</b></li>
                            @if ($po_datas->quotdt!='')
                                <li class="a2">{{date('d-m-Y', strtotime($po_datas->quotdt))}}</li>
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
                            <li class="a1"><b>INDENT NO</b></li>
                            @if ($po_datas->indentno!='')
                                <li class="a2">{{$po_datas->indentno}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="b">
                            <li class="a1"><b>INDENT DATE</b></li>
                            @if ($po_datas->indentdate!='')
                            <li class="a2">{{date('d-m-Y', strtotime($po_datas->indentdate))}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="c">
                            <li class="a1"><b>PURCHASE TYPE</b></li>
                            @if ($po_datas->purchasetype!='')
                                <li class="a2">{{$po_datas->purchasetype}}</li>
                            @else
                                <li class="a2">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="d">
                            <li class="a1"><b>PAYMENT</b></li>
                            @if ($po_datas->payment_terms!='')
                                <li class="a2">{{$po_datas->payment_terms}}</li>
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
                        <div class="col-7">
                            <ul>
                                <li style="font-size: 12px!important"><b>SUPPLIER NAME & ADDRESS :</b></li>
                                <li style="font-size: 12px!important"><b>{{$po_datas->supplier->name}},</b></li>
                                <li style="font-size: 12px!important">{{$po_datas->supplier->contact_person}} - {{$po_datas->supplier->contact_number}},</li>
                                <li style="font-size: 12px!important">{{$po_datas->supplier->address}},{{$po_datas->supplier->address1}},</li>
                                <li style="font-size: 12px!important">{{$po_datas->supplier->city}},{{$po_datas->supplier->state}} - {{$po_datas->supplier->pincode}}.</li>
                                <li style="font-size: 12px!important">GSTIN : {{$po_datas->supplier->gst_number}}.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul>
                                <li style="font-size: 12px!important"><b>SCHEDULE DETAILS :</b></li>
                                <li style="font-size: 12px!important">{{$po_datas->remarks1}}</li>
                                <li style="font-size: 12px!important">{{$po_datas->remarks2}}</li>
                                <li style="font-size: 12px!important">{{$po_datas->remarks3}}</li>
                                <li style="font-size: 12px!important">{{$po_datas->remarks4}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="col-11 mx-auto" style="min-height:520px;max-height:520px;">
                        <div class="table-responsive">
                            <table class="table table-bordered border-dark" style="min-height:420px;max-height:420px;">
                                <thead>
                                    <tr style="font-family: arial;font-size:11px;text-align:center;color:black;font-weight:10px;vertical-align: top;">
                                        <td style="max-width:10px!important"><b>S.No</b></td>
                                        <td><b>DESCRIPTION OF GOODS</b></td>
                                        <td style="width:50px"><b>HSN CODE</b></td>
                                        <td><b>DUE DATE</b></td>
                                        <td><b>QTY</b></td>
                                        <td><b>UOM</b></td>
                                        <td><b>UNIT RATE</b></td>
                                        <td><b>VALUE</b></td>
                                    </tr>
                                </thead>
                                <tbody >
                                    @foreach ($po_product_datas as $po_product_data)
                                    <tr  style="font-family: arial;font-size:11px;text-align:left;color:black;">
                                        <td style="max-width:10px!important">{{$loop->iteration}}</td>
                                        <td style="width:350px">{{$po_product_data->supplier_products->material->name}}</td>
                                        <td style="width:50px">{{$po_product_data->supplier_products->products_hsnc}}</td>
                                        <td style="width:80px">{{date('d-m-Y', strtotime($po_product_data->duedate))}}</td>
                                        <td>{{$po_product_data->qty}}</td>
                                        <td>{{$po_product_data->uom_datas->name}}</td>
                                        <td>{{$po_product_data->rate}}</td>
                                        <td>{{$po_product_data->basic_value}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="font-family: arial;font-size:11px;text-align:left;color:black;">
                                        <td colspan="7" style="font-family: arial;font-size:11px;text-align:right;color:black;"><b>SUB TOTAL</b> </td>
                                        <td><b>{{($total_basic_value)}}</b></td>
                                    </tr>
                                    <tr style="font-family: arial;font-size:11px;text-align:left;color:black;">
                                        <td><b>CGST/ <br>SGST</b></td>
                                        <td>{{($po_datas->supplier->cgst)+($po_datas->supplier->sgst)}} % <br> {{($total_cgstamt)+($total_sgstamt)}}</td>
                                        <td><b>IGST</b></td>
                                        <td>{{($po_datas->supplier->igst)}} % <br> {{($total_igstamt)}}</td>
                                        <td><b>PC</b></td>
                                        <td>{{($po_datas->supplier->packing_charges)}} % <br> {{($total_packing_charge_amt)}}</td>
                                        <td><b>TAX AMOUNT</b></td>
                                        <td><b>{{($tax_amount)}}</b></td>
                                    </tr>
                                    <tr style="font-family: arial;font-size:11px;text-align:left;color:black;">
                                        <td colspan="6">Rupees In Words : <b>{{$a}}</b></td>
                                        <td><b>TOTAL</b></td>
                                        <td><b>{{($po_total)}}</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="col-12">
                        <ul>
                            <li style="font-size: 12px!important"><b>TERMS & CONDITIONS :</b></li>
                            <li style="font-size: 12px!important">1.Only the order/Schedule Quantity should be supplied.</li>
                            <li style="font-size: 12px!important">2.The GRN will be approved only on acceptance of 100% materials supplied by you .</li>
                            <li style="font-size: 12px!important">3.The PO No. should be mentioned in the DC and invoices.</li>
                            <li style="font-size: 12px!important">4.Any Clarifications in the PO should be addressed to us with in 7 days from the date of receipt of PO.</li>
                            <li style="font-size: 12px!important">5.Original and Duplicate for Transaporter Invoices and test certificate should be sent along with the materials .</li>
                            <li style="font-size: 12px!important">6.The Supplier QMS development programme to ensure as a minimum that supplier's certification to ISO 9001:2015 Requirements for Automotive
                                    supplier's.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-11  d-flex">
                    <div class="col-8">
                        <ul class="a">
                            <li class="a3" style="font-family: arial;font-size:11px;"><b>Despatch Mode</b></li>
                            @if ($po_datas->supplier->trans_mode!='')
                                <li class="a4" style="font-family: arial;font-size:11px;">{{($po_datas->supplier->trans_mode)}}</li>
                            @else
                                <li class="a4" style="font-family: arial;font-size:11px;">&nbsp;</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul class="a">
                            <li class="a5" style="font-family: arial;font-size:11px;"><b>Authorised signatory( FOR VSSIPL)</b></li>
                            <li class="a6 d-flex" style="font-family: arial;font-size:11px;">
                                <img src="{{asset('image/e-sales4.png')}}" class="m-auto" width="51%" height="27%" alt="" srcset="">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="policy">
            <div class="row mt-1">
                <div class="container">
                    <div class="col-12  d-flex">
                        <div class="col-6">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>1.SPECIFICATIONS<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).All goods ordered unless otherwise changed to subsequent Instructions shall conforms to the specifications / drawings standards and quality agreed upon.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).The seller represents' the any article or apparatus. software or any part there of consistrng goods or service furnished under this order does not infringe any third party intellectual property rights and undertakers to defend any suit or other proceeding brought against VSSIPL and customer for dealing mg with such goods and to pay all damages and cost awarded there in against VSSIPL its agents and customers.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>2. PRICE<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).The price agreed upon fixed, exclusive of all levies by the central of State Government, now applicable to the goods and the buyer shall not be liable for any fresh cesses, duties, taxes or any other levies which only the supplier should meet.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).The seller shall not modify, revise and/ or very the prices of the goods unless notice in given to the buyer and accepted by him in writing within fitteen days of the receipt of the purchase order.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12  d-flex">
                        <div class="col-6">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>3. DELIVERY<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">The goods shall be deemed to be delivered only when the goods are taken delivery and the seller shall be liable or responsible for any damage, destruction, deterioration and/ or loss to or in the goods till then and compensate the buyer accordingly.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>4. PACKING REQUIREMENTS<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).Packing of goods should be as per VSSIPL packing requirements. if specified in the Purchase order.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).If the packing is not to the requirements, goods will not be inwarded.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12  d-flex">
                        <div class="col-6">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>5. INSPECTION STATUS<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).Inspection at our site unless otherwise Specified. where the goods are rejected by the buyer as not conforming to specifications or standards as per our order, and the goods are returned to the seller the proportionate cost of freight, loading, unloading and any other charges incidental there to shouid be borne by the seller.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).where a part of the supplier are the rejected as not conforming to specification and standards agreed to buyer has the right to pass the bills of the Seller after deducting the value of rejected supplies, proportionate freight and other charges etc.,</li>
                                <li style="font-size: 10px!important;text-align: justify">(iii).If the goods are not delivered as specified in the order or as may be agreed otherwise the buyer wi11 have the option not to accept the goods.</li>
                                <li style="font-size: 10px!important;text-align: justify">(iv).Where Supplies made against documents retired through Banks are rejected on whole or in part by the buyer the seller should effect payment of the value thereof.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>6.DESPATCH<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).The seller shall despatch all supplies through the authorized carriers of buyer's choice. In other cases if excessive rates are fixed by the seller such express freight shall to sellers account.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).Where the instructions are given to the carriers for door delivery and the carriers do not affect door delivery proportionate freight loading, unloading and any other incidental charges that may be paid by the buyer shall be to the sellers account.</li>
                                <li style="font-size: 10px!important;text-align: justify">(iii).If the seller shall not follow the sales tax regulations and consequentity If the buyer has to pay any penalty or other expenses for loading, unloading etc. at check posts the seller shall make goods such loss sustained by the buyer.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12  d-flex">
                        <div class="col-6">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>7. BANK INSTRUCTIONS<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">Where documents send through Bank are not received in time and the buyer is called Upon to pay interest demurrage, wharfage and any other expenses incidental thereto, such expenses shall be to the sellers account.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>8. INSURANCE<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">The buyer have the right to insure the goods himself. If the buyer dose not insure he may ask the seller fo effect the insurance.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12  d-flex">
                        <div class="col-6">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>9. LIEN<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">The buyer shall be entitled to a general lien on the goods in his possession under this contract for any monies for the timing being due to the buyer from the seller.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>10. DISPUTES<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).ln the event of any contradictions between the above conditions and the general conditions of the seller the buyer's condition will prevail.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).This contract, shall be deemed to have been made at Coimbatore and all suits and proceedings relating to this contract shall be instituted in any court of competent jurisdiction in Coimbatore.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12  d-flex">
                        <div class="col-6">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>11. DOCUMENTATION REQUIREMENTS<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">Sub contractors delivery challan should have the following information's.</li>
                                <li style="font-size: 10px!important;text-align: justify">(i).Name and address of the company</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).Purchase order No. and date</li>
                                <li style="font-size: 10px!important;text-align: justify">(iii).Description</li>
                                <li style="font-size: 10px!important;text-align: justify">(iv).Quantity.</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>12. INFORMATION FOR SHELF LIFE ITEMS<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).Materials should be delivery at our factory at least 3 months before the expiry date otherwise the materials will be rejected</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).Storing Instructions (If any)</li>
                                <li style="font-size: 10px!important;text-align: justify">(iii).Each and every supply / Batch should accompany the test certificate if required</li>
                                <li style="font-size: 10px!important;text-align: justify">(iv).Batch Number, Manufacturing date and expiry date wherever necessary should be available on the packing Slip / Delivery Challan.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12  d-flex">
                        <div class="col-11">
                            <ul class="a">
                                <li style="font-size: 10px!important;text-align: left"><b>13. DEFECTIVE SUPPLIES<h6></h6></b></li>
                                <li style="font-size: 10px!important;text-align: justify">(i).The buyer shall within 30 days from the date of the receipt of the goods give notice to the seller of any defects. cannot be notice to the buyer immediately but only on utilizing the goods in the Manufacturing Processes. The Buyer Shall have the right to clime the requisite compensation from the seller for replacement of the defective goods free of cost and the replacement shall be made by the seller within 10 days on the receipt of the notice from the buyer to the seller to that effect. The defective goods shall be returned by the buyer to the seller within 30 days of such notice.</li>
                                <li style="font-size: 10px!important;text-align: justify">(ii).If the replacement in not so made within the times as stated in the previous paragraph, the buyer shall have the liberty to get such goods substitute from other sellers in the market and the seller shall pay to the buyer the cost thereof.</li>
                                <li style="font-size: 10px!important;text-align: justify">(iii).The buyer shall not be responsible for any damage, penalties etc., For the infringement of the patent registered design.</li>
                            </ul>
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
