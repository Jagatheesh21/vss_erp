<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:7px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:7px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg .tg-nrw1{font-size:10px;text-align:center;vertical-align:top}
        .tg .tg-baqh{text-align:center;vertical-align:top}
        .tg .tg-7fgq{font-weight:bold;font-family:"Comic Sans MS", cursive, sans-serif !important;;text-align:center;vertical-align:top}
        .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-yw4l{vertical-align:top}
    </style>
    @stack('styles')
</head>
<body>
    <table class="tg" style="undefined;table-layout: fixed; width: 900px!important">
        <colgroup>
        <col style="width: 86.66667px">
        <col style="width: 166.66667px">
        <col style="width: 86.66667px">
        <col style="width: 95.66667px">
        <col style="width: 88.66667px">
        <col style="width: 88.66667px">
        <col style="width: 90.66667px">
        <col style="width: 86.66667px">
        <col style="width: 106.66667px">
        <col style="width: 76.66667px">
        <col style="width: 48.66667px">
        </colgroup>
          <tr>
            <th class="tg-7fgq" colspan="7" rowspan="2">MASTER ROUTE CARD - VSSIPL - 1<br></th>
            <th class="tg-baqh" colspan="2">Issue date</th>
            <th class="tg-baqh" colspan="2">{{date('d-m-Y', strtotime($d12Datas->open_date))}} </th>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Closing Date</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">MASTER ROUTE CARD #</td>
            <td class="tg-amwm" colspan="3">{{$d12Datas->current_rcmaster->rc_id}}</td>
            <td class="tg-baqh" colspan="3" rowspan="2">{{$qrCodes}}</td>
            <td class="tg-baqh">Format.No</td>
            <td class="tg-baqh" colspan="2">STR/R/09</td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">PART NUMBER</td>
            <td class="tg-baqh" colspan="3">{{$d12Datas->partmaster->child_part_no}}</td>
            <td class="tg-baqh">Rev No / DATE</td>
            <td class="tg-baqh" colspan="2"> 00 / 02.01.2017 </td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Size with Grade / Coil size</td>
            <td class="tg-baqh" colspan="3">{{$d12Datas->rm_master->name}}</td>
            <td class="tg-baqh" colspan="2">Coil Number</td>
            <td class="tg-baqh" colspan="2">Coil No</td>
            <td class="tg-baqh" colspan="2">{{$d12Datas->heat_nomaster->coil_no}}</td>
          </tr>
          <tr>
            <td class="tg-nrw1" colspan="2">Raw Material Lot s.no - Heat code</td>
            <td class="tg-baqh" colspan="3">{{$d12Datas->heat_nomaster->coil_no}}-{{$d12Datas->heat_nomaster->heatnumber}}</td>
            <td class="tg-baqh" colspan="2">RM.T.C Number</td>
            <td class="tg-baqh" colspan="4">{{$d12Datas->heat_nomaster->tc_no}}</td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Manufacturer</td>
            <td class="tg-baqh" colspan="3"><?php ?></td>
            <td class="tg-baqh" colspan="2">Supplier Name</td>
            <td class="tg-baqh" colspan="4">{{$d12Datas->grndata->tc_no}}</td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Gin Number and Date</td>
            <td class="tg-baqh" colspan="2">{{$d12Datas->grndata->rcmaster->rc_id}}</td>
            <!-- <td class="tg-baqh" colspan="2">G2020005376</td> -->
            <td class="tg-baqh" colspan="2">{{$d12Datas->grndata->grndate}}</td>
            <td class="tg-baqh" colspan="1">Inv No &amp; Date</td>
            <td class="tg-baqh" colspan="2">{{$d12Datas->grndata->invoice_number}}</td>
            <td class="tg-baqh" colspan="2">{{$d12Datas->grndata->invoice_date}}</td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">WORK ORDER QTY</td>
            <td class="tg-baqh" colspan="2"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="3">REQUIRED WEIGHT IN KG</td>
            <td class="tg-baqh" colspan="3"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Physical issue coil weight</td>
            <td class="tg-baqh" colspan="2">{{$d12Datas->rm_issue_qty}}</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="3">Bal RETURN TO STORES WT</td>
            <td class="tg-baqh" colspan="3"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Stores Person Name</td>
            <td class="tg-baqh" colspan="2"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-yw4l"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Coil Loading DATE &amp; shift &amp; Time</td>
            <td class="tg-baqh" colspan="2">Date</td>
            <td class="tg-baqh" colspan="2">Shift</td>
            <td class="tg-baqh" colspan="2">Time</td>
            <td class="tg-baqh" colspan="3">Total running hours</td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">Coil Loading DATE &amp; shift &amp; Time</td>
            <td class="tg-baqh" colspan="2">Date</td>
            <td class="tg-baqh" colspan="2">Shift</td>
            <td class="tg-baqh" colspan="2">Time</td>
            <td class="tg-baqh" colspan="3"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="3">DEPARTMENT&amp;MACHINE</td>
            <td class="tg-baqh" colspan="4"></td>
            <td class="tg-baqh" colspan="4"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="11">MATERIAL PROCESS DETAILS</td>
          </tr>
          <tr>
            <td class="tg-baqh">SL.No</td>
            <td class="tg-baqh">MACHINE ID</td>
            <td class="tg-baqh">DATE</td>
            <td class="tg-baqh">SHIFT</td>
            <td class="tg-baqh">OPER-<br>ATOR</td>
            <td class="tg-baqh">PART<br>NUMBER</td>
            <td class="tg-baqh">OK-(KGS)</td>
            <td class="tg-baqh">R/W-(KGS)</td>
            <td class="tg-baqh">SCRAP-<br>(KGS)</td>
            <td class="tg-baqh" colspan="2">FOREMAN SIGNATURE</td>
          </tr>
          <tr>
            <td class="tg-baqh">1</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">2</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">3</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">4</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">5</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">6</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">7</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">8</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">9</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh">10</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="6">Total QTY</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="6">Total KG</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="6">Balence Coil Return To Stores (KG)</td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="2">FOREMAN SIGN</td>
            <td class="tg-baqh" colspan="3"></td>
            <td class="tg-baqh" colspan="2">STORES SIGN</td>
            <td class="tg-baqh" colspan="4"></td>
          </tr>
          <tr>
            <td class="tg-baqh" colspan="7">ROUTE CARD CLOSING DETAIL</td>
            <td class="tg-baqh" colspan="4">STORES ALERT</td>
          </tr>
          <tr>
            <td class="tg-baqh">DATE</td>
            <td class="tg-baqh">CHILD RC NO</td>
            <td class="tg-baqh">QTY ISSUE</td>
            <td class="tg-baqh">KG ISSUE</td>
            <td class="tg-baqh">RECEIVED</td>
            <td class="tg-baqh" colspan="2">ISSUED BY</td>
            <td class="tg-baqh" colspan="4">STOCK DETAIL EXCEPT THIS MRC</td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">PART NO</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">MAX STOCK</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">SEMI FINS</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">WIP</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">FG</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">OUT SC</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">TOTAL</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh"></td>
            <td class="tg-baqh" colspan="2">RC VALID QUANTITY</td>
            <td class="tg-baqh" colspan="2"></td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="5">PREPARED BY</td>
            <td class="tg-yw4l" colspan="6">RECEIVED BY</td>
          </tr>
        </table>
</body>
</html>
