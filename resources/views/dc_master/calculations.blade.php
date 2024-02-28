@extends('layouts.app')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="form-group">
                <label for="">DC Quantity</label>
                <input type="text" class="form-control col-4" name="dc_quantity" id="dc_quantity">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Part Number</th>
                        <th>Part Quantity</th>
                        <th>Quantity</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for($i=1;$i<=15;$i++)
                    
                    <tr>
                        <td><input type="text" class="form-control part_number" value="{{$i}}" readonly="true"></td>
                        <td><input type="text" class="form-control part_quantity" value="{{$i*12}}" readonly="true"></td>
                        <!-- <td><input type="text" class="form-control total" value="" readonly="true"></td> -->
                        <td><input type="text" class="form-control quantity" value=""></td>
                        <td><input type="text" class="form-control balance" value="" readonly></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>    
    </div>
@endsection
@push('scripts')
    <script>
        $("#dc_quantity").change(function(){
            // if($(this).val() !=''){
            //     return false;
            // }
            var dc_quantity = $(this).val();
            var total = dc_quantity;
            $('table > tbody  > tr').each(function(index, row) { 
            $(row).find('.quantity').val('');
            var qty = $(row).find('.part_quantity').val();
            if(total>=qty && total>0){
                total-=qty;
                $(row).find('.quantity').val(qty);
                //$(row).find('.total').val(total);
                console.log('method 1');
                //console.log('method 1 total:'+total);
                //console.log('method 1 qty:'+qty);
            }else if(qty>total){
               $(row).find('.quantity').val(total);
                
                //console.log('method 2');
               // console.log("qty"+qty);
                total = 0;
                //console.log("total"+total);
                // $(row).find('.quantity').val(total);
                //$(row).find('.total').val(total);
                // console.log(total);
                // console.log(qty);
                
            }
            // if(total<qty && total>0){
            //     if(qty>total){
            //         console.log('test');
            //         $(row).find('.quantity').val(total);
            //     }else{
            //         $(row).find('.quantity').val(total);
            //     }
            //      total = qty-total;
            //      $(row).find('.total').val(total);

            //     console.log('method 2');
            //     console.log('method 2 total:'+total);
            //     console.log('method 2 qty:'+qty);

            // }
            var balance = qty-($(row).find('.quantity').val());
            $(row).find('.balance').val(balance);
            });
        });
    </script>
@endpush