<tr id="saved">
    <td><select name="rack_id[]"  class="form-control rack_id" id="rack_id">
        <option value="">Select Rack ID</option>
        @foreach ($racks as $rack)
        <option value="{{$rack->id}}">{{$rack->rack_name}}</option>
        @endforeach
    </select></td>
    <td><input type="text" class="form-control heatnumber"  name="heatnumber[]" id="heatnumber"></td>
    <td><input type="text"  class="form-control tc_no" name="tc_no[]" id="tc_no"></td>
    <td><input type="text" class="form-control lot_no" id="lot_no" name="lot_no[]"></td>
    <td><input type="number"  class="form-control coil_no" name="coil_no[]" id="coil_no"></td>
    <td><select name="uom_id[]"  class="form-control bg-white uom_id" id="uom_id"><option value="">Select UOM</option>
    <option value="{{$uom_data->id}}" selected>{{$uom_data->name}}</option></td>
    <td><input type="number" class="form-control coil_inward_qty" name="coil_inward_qty[]" id="coil_inward_qty"></td>
    <td><button class="btn btn-sm btn-danger text-white remove_item" >Remove</button></td>
</tr>
<script>

    $(".remove_item").click(function(){
        $(this).closest('tr').remove();
        updateGrandTotal();
        });
        $("#tab_logic").on('change', 'input', updateGrandTotal);

</script>
