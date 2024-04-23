@extends('layouts.app')
@push('styles')

@endpush
@section('content')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
        <div class="row col-md-3"id="res"></div>
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Traceability Report</b></span><a class="btn btn-sm btn-primary" href="{{route('invoicedetails.index')}}">Invoice List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="invoice_id">
                                    <label for="invoice_number">Invoice No. *</label>
                                    <input type="text" name="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror">
                                    @error('invoice_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <button class="btn btn-primary mt-4" id="proceed">Check</button>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mt-3" id="table1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('scripts')
<script>
        $("#invoice_number").blur(function (e) {
            e.preventDefault();
            var invoice_no=$(this).val();
            if (invoice_no!='') {
                $.ajax({
                type: "POST",
                url: "{{route('rcinvoice_data')}}",
                data: {"invoice_no":invoice_no},
                success: function (response) {
                    // alert(response);
                    $('#table1').html(response.table1);
                    $('#invoice_number').val(response.rc_no);
                }
            });
            }else{
                alert('Sorry Please Correct Invoice Number...');
            }
        });
</script>
@endpush

