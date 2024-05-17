<div class="col-md-12">
    <div class="table-responsive">
        <table class='table table-bordered table-striped table-responsive rm_{{$grn_id}}'>
            <thead>
            <tr>
                <th><b>Heat Number</b></th>
                <th><b>Coil No</b></th>
                <th><b>Lot No</b></th>
                <th><b>T.C No</b></th>
                <th><b>Coil Available Qty</b></th>
                <th><b>DC Qty</b></th>
                <th><b>Balance</b></th>
            </tr>
            </thead>
            <tbody >
                @forelse ($grnQcDatas as $grnQcData)
                <tr >
                    <td><select name="heat_id[]" class="form-control bg-light heat_id" id="heat_id"><option value="{{$grnQcData->heat_no_data->id}}">{{$grnQcData->heat_no_data->heatnumber}}</option></select></td>
                    <td><input type="number" name="coil_no[]" step="0.001"  class="form-control bg-light coil_no"  id="coil_no" value="{{$grnQcData->heat_no_data->coil_no}}"></td>
                    <td><input type="number" name="lot_no[]" step="0.001" class="form-control bg-light lot_no"  id="lot_no" value="{{$grnQcData->heat_no_data->lot_no}}"></td>
                    <td><input type="text" name="tc_no[]"  class="form-control bg-light tc_no"  id="tc_no" value="{{$grnQcData->heat_no_data->tc_no}}"></td>
                    <td><input type="number" name="available_quantity[]" step="0.001"  class="form-control bg-light available_quantity"  id="available_quantity" value="{{(($grnQcData->approved_qty)-($grnQcData->issue_qty))}}"></td>
                    <td><input type="number" name="issue_quantity[]" step="0.001"  class="form-control bg-light issue_quantity" id="issue_quantity" min="0" max="{{(($grnQcData->approved_qty)-($grnQcData->issue_qty))}}" ></td>
                    <td><input type="number" name="balance[]" step="0.001"  class="form-control bg-light balance" id="balance" min="0" max="{{(($grnQcData->approved_qty)-($grnQcData->issue_qty))}}"></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" align="center">No Records Found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


