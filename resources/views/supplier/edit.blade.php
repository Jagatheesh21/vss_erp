@extends('layouts.app')
@section('content')
<form action="{{route('supplier.update',$supplier->id)}}" id="supplier_formdata" method="POST">
    @csrf
    @method('PUT')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Supplier Updation</b></span><a class="btn btn-sm btn-primary" href="{{route('supplier.index')}}">Supplier List</a>
            </div>
            <input type="hidden" name="id" value="{{$supplier->id}}">

            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_code">Code *</label>
                                    <input type="text" name="supplier_code" id="supplier_code" value="{{$supplier->supplier_code}}" class="form-control @error('supplier_code') is-invalid @enderror" >
                                    @error('supplier_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Name *</label>
                                    <input type="text" name="name" id="name"  value="{{$supplier->name}}" class="form-control @error('name') is-invalid @enderror" >
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Contact *</label>
                                    <input type="text" name="contact_number" id="contact_number"  value="{{$supplier->contact_number}}" class="form-control @error('contact_number') is-invalid @enderror" >
                                    @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">GST Number *</label>
                                    <input type="text" name="gst_number" maxlength="15" minlength="15" id="gst_number"  value="{{$supplier->gst_number}}" class="form-control @error('gst_number') is-invalid @enderror" >
                                    @error('gst_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Address *</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" id="" cols="20" rows="4">{{$supplier->address}}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="trans_mode">Mode Of Transaction*</label>
                                    <select name="trans_mode" id="trans_mode" class="form-control @error('trans_mode') is-invalid @enderror">
                                        <option value="BY ROAD" @if($supplier->trans_mode=="BY ROAD") selected @endif >BY ROAD</option>
                                        <option value="BY COURIER" @if($supplier->trans_mode=="BY COURIER") selected @endif>BY COURIER</option>
                                    </select>
                                    @error('trans_mode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cgst">CGST (%) *</label>
                                    <input type="number" name="cgst" id="cgst"  value="{{$supplier->cgst}}" class="form-control @error('cgst') is-invalid @enderror" >
                                    @error('cgst')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sgst">SGST (%) *</label>
                                    <input type="number" name="sgst" id="sgst" min="0"  value="{{$supplier->sgst}}" class="form-control @error('sgst') is-invalid @enderror" >
                                    @error('sgst')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="igst">IGST (%) *</label>
                                    <input type="number" name="igst" id="igst"  value="{{$supplier->igst}}" class="form-control @error('igst') is-invalid @enderror" >
                                    @error('igst')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="packing_charges">Packing Charge (%) *</label>
                                    <input type="number" name="packing_charges" id="packing_charges"  value="{{$supplier->packing_charges}}" class="form-control @error('packing_charges') is-invalid @enderror" >
                                    @error('packing_charges')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="currency_id">Mode Of Currency*</label>
                                    <select name="currency_id" id="currency_id"  class="form-control @error('currency_id') is-invalid @enderror">
                                        @forelse ($currency_datas as $currency_data)
                                            <option value="{{$currency_data->id}}"
                                            @if($currency_data->id==$supplier->currency_id) selected @endif>{{$currency_data->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('currency_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Remarks *</label>
                                    <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" id="" cols="20" rows="4">{{$supplier->remarks}}</textarea>
                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select name="status" class="form-control">
                                        <option value="1" @if($supplier->status==1) selected @endif >Active</option>
                                        <option value="0" @if($supplier->status==0) selected @endif>Inactive</option>
                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-2 mt-4">
                                <button class="btn btn-sm btn-primary" id="submit_btn" type="submit">Submit</button>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
</form>

<script src="{{asset('js/jquery.min.js')}}"></script>

<script>
$(document).ready(function(){
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $("#supplier_code").change(function(e){
        e.preventDefault();
        var supplier_code=$(this).val();
        $.ajax({
            url: "{{ route('suppliersdata') }}?id=" + $(this).val(),
            method: 'GET',
            cache:false,
            processData:false,
            contentType:false,
            success : function(result){
                console.log(result);
                if (result.count > 0) {
                    $('#name').val(result.name);
                    $('#contact_number').val(result.contact_number);
                    $('#gst_number').val(result.gst_number);
                    $('#address').val(result.address);
                    $('#trans_mode').html(result.trans_mode);
                    $('#cgst').val(result.cgst);
                    $('#sgst').val(result.sgst);
                    $('#igst').val(result.igst);
                    $('#packing_charges').val(result.packing_charges);
                    $('#currency_id').html(result.currency_id);
                    $('#remarks').val(result.remarks);
                    $("#submit_btn").attr('disabled',true);
                    $("#submit_btn").val('Save');
                    alert('This Supplier Code Already Exist!!!')
                    setTimeout(() => {
                        location.reload(true);
                    }, 3000);
                }else{
                    $('#name').val('');
                    $('#contact_number').val('');
                    $('#gst_number').val('');
                    $('#address').val('');
                    $('#trans_mode').html(result.trans_mode);
                    $('#cgst').val('');
                    $('#sgst').val('');
                    $('#igst').val('');
                    $('#packing_charges').val('');
                    $('#currency_id').html(result.currency_id);
                    $('#remarks').val('');
                    $("#submit_btn").attr('disabled',false);

                }
            }
        });
	});
});
</script>
@endsection