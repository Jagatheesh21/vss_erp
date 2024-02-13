<tr>
    <td><select name="raw_material_category_id[]"  class="form-control raw_material_category_id" onChange="get_material();">
        <option value="">Select Material Category</option>
        @foreach ($supplier_products as $key => $supplier_product)
        <option value="{{$supplier_product->raw_material_category_id}}">{{$supplier_product->category->name}}</option>
        @endforeach
    </select></td>
    <td><select name="supplier_product_id[]" id="" class="form-control supplier_product_id"></select></td>
    <td><input type="text" class="form-control products_hsnc"  name="products_hsnc[]"></td>
    <td><input type="date" class="form-control duedate" id="duedate" name="duedate[]"></td>
    <td><select name="uom_id[]"  class="form-control bg-white uom_id"></td>
    <td><input type="number"  class="form-control products_rate" name="products_rate[]" readonly></td>
    <td><input type="text"  class="form-control qty" name="qty[]" value="1"></td>
    <td><input type="number" class="form-control rate" name="rate[]" readonly></td>
    <td><button class="btn btn-sm btn-danger text-white remove_item">Remove</button></td>
</tr>
<script>
        $(".raw_material_category_id").change(function(e){
        e.preventDefault();
        var closestTr = $(this).closest('tr');
        $(".raw_material_category_id").select2();
        var supplier_id=$("#supplier_id").val();
        var raw_material_category_id=$(this).val();
        $.ajax({
            url: "{{ route('posuppliersrmdata') }}",
            method: 'POST',
            data:{
                "_token": "{{ csrf_token() }}",
                "raw_material_category_id":raw_material_category_id,
                "supplier_id":supplier_id
            },
            success : function(result){
                $(".raw_material_category_id").select2();
                closestTr.find('.supplier_product_id').html(result);
            }
        });
	});
    $(".supplier_product_id").change(function(e){
        e.preventDefault();
        var supplier_id=$("#supplier_id").val();
        var closestTr = $(this).closest('tr');
        var raw_material_category_id=closestTr.find(".raw_material_category_id").val();
        var supplier_product_id=$(this).val();
        $("#supplier_product_id").select2();
        $.ajax({
            url: "{{ route('posuppliersproductdata') }}",
            method: 'POST',
            data:{
                "_token": "{{ csrf_token() }}",
                "raw_material_category_id":raw_material_category_id,
                "supplier_id":supplier_id,
                "supplier_product_id":supplier_product_id,
            },
            success : function(result){
                $(".supplier_product_id").select2();
                closestTr.find(".uom_id").html(result.html);
                closestTr.find(".products_hsnc").val(result.products_hsnc);
                closestTr.find(".products_rate").val(result.products_rate);
                calculate();
            }
        });
	});
    $('.qty').change(function (e) {
        e.preventDefault();
        var closestTr = $(this).closest('tr');
        var products_rate=closestTr.find(".products_rate").val();
        var qty=$(this).val();
        if(products_rate!=''&&qty!=''){
            var total_cost=products_rate * qty;
            closestTr.find(".rate").val(total_cost);
        }
        calculate();
    });
    $(".remove_item").click(function(){
        $(this).closest('tr').remove();
        calculate();
        // swalWithBootstrapButtons.fire({
        // title: 'Are you sure?',
        // text: "You want to remove this item!",
        // icon: 'warning',
        // showCancelButton: true,
        // confirmButtonText: 'Yes, Remove it!',
        // cancelButtonText: 'No, cancel!',
        // reverseButtons: true
        // }).then((result) => {
        // if (result.isConfirmed) {
        // }
        }); 
</script>