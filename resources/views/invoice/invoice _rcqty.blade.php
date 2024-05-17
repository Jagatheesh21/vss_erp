<input type="hidden" name="ino_qty" id="ino_qty" value="{{$invoice_quantity}}">
<div class="col-md-12">
    <div class="table-responsive">
        <table class='table table-bordered table-striped table-responsive part_{{$m_part_id}}'>
            <thead>
            <tr>
                <th><b>Part No</b></th>
                <th><b>Order</b></th>
                <th><b>Route Card</b></th>
                <th><b>Route Card Available Quantity</b></th>
                <th><b>Invoice Quantity</b></th>
                <th><b>Balance</b></th>
            </tr>
            </thead>
            <tbody >
                @forelse ($invoiceRcDatas as $invoiceRcData)
                <tr class="order_{{$invoiceRcData->partmaster->no_item_id}}">
                    <td><select name="route_part_id[]" class="form-control bg-light route_part_id" id="route_part_id"><option value="{{$invoiceRcData->partmaster->id}}">{{$invoiceRcData->partmaster->child_part_no}}</option></select></td>
                    <td><input type="number" name="order_no[]"  class="form-control bg-light order_no"  id="order_no" value="{{$invoiceRcData->partmaster->no_item_id}}"></td>
                    <td><select name="route_card_id[]" class="form-control bg-light route_card_id" id="route_card_id"><option value="{{$invoiceRcData->rcmaster->id}}">{{$invoiceRcData->rcmaster->rc_id}}</option></select></td>
                    <td><input type="number" name="available_quantity[]"  class="form-control bg-light available_quantity"  id="available_quantity" value="{{$invoiceRcData->avl_qty}}"></td>
                    <td><input type="number" name="issue_quantity[]"  class="form-control bg-light issue_quantity" id="issue_quantity" min="0" max="{{$invoiceRcData->avl_qty}}" ></td>
                    <td><input type="number" name="balance[]"  class="form-control bg-light balance" id="balance" min="0" max="{{$invoiceRcData->avl_qty}}"></td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6" align="center">No Records Found!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



<script>
$(document).ready(function () {
    var route_part_id=$('.route_part_id').val();
    $('table.part_'+route_part_id+' > tbody  > tr').each(function(index, row) {
        // var invoice_quantity = 4;
        var invoice_quantity = $('#ino_qty').val();
    alert('invoice_quantity');
        var total = invoice_quantity;
        $(row).find('.issue_quantity').val('');
        var qty = $(row).find('.available_quantity').val();
        if(total>=qty && total>0){
            total-=qty;
            $(row).find('.issue_quantity').val(qty);
            // console.log('method 1');
        }else if(qty>total){
            $(row).find('.issue_quantity').val(total);
            total = 0;
        }
        var balance = qty-($(row).find('.issue_quantity').val());
            $(row).find('.balance').val(balance);
    });
});

</script>
