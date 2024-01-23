@extends('layouts.app')
@section('content')
<form action="{{route('supplier-products.update',$supplierProduct->id)}}" id="supplier-products_formdata" method="POST">
    @csrf
    @method('PUT')

<div class="row d-flex justify-content-center">
    <div id="data"></div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> <b>Supplier Product Updattion</b></span><a class="btn btn-sm btn-primary" href="{{route('supplier-products.index')}}">Supplier Products List</a>
            </div>
            <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <input type="hidden" name="id" value="{{$supplierProduct->id}}">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Code *</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                    <option value=""></option>
                                    @forelse ($supplier_codes as $code)
                                        <option value="{{$code->id}}" @if($supplierProduct->supplier_id==$code->id) selected @endif >{{$code->supplier_code}}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                    @error('supplier_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">RM Category *</label>
                                    <select name="raw_material_category_id" id="raw_material_category_id" class="form-control @error('raw_material_category_id') is-invalid @enderror">
                                        <option value=""></option>
                                        @forelse ($categories as $category)
                                            <option value="{{$category->id}}" @if($supplierProduct->raw_material_category_id==$category->id) selected @endif>{{$category->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('raw_material_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Material Description *</label>
                                    <select name="raw_material_id" id="raw_material_id" class="form-control @error('raw_material_id') is-invalid @enderror">
                                        <option value=""></option>
                                        @forelse ($rm_datas as $rm_data)
                                            <option value="{{$rm_data->id}}" @if($supplierProduct->raw_material_id==$rm_data->id) selected @endif>{{$rm_data->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('raw_material_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Material HSN Code *</label>
                                    <input type="number" name="products_hsnc" id="products_hsnc" value="{{$supplierProduct->products_hsnc}}" class="form-control @error('products_hsnc') is-invalid @enderror" >
                                    @error('products_hsnc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Unit of Measure (UOM) *</label>
                                    <select name="uom_id" id="uom_id" class="form-control @error('uom_id') is-invalid @enderror">
                                        <option value=""></option>
                                        @forelse ($units as $unit)
                                            <option value="{{$unit->id}}" @if($supplierProduct->uom_id==$unit->id) selected @endif>{{$unit->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('uom_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="products_rate">Rate *</label>
                                    <input type="number" name="products_rate" id="products_rate" value="{{$supplierProduct->products_rate}}" min="0" step="0.01" class="form-control @error('products_rate') is-invalid @enderror" >
                                    @error('products_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status *</label>
                                    <select name="status" class="form-control">
                                        <option value="1" @if($supplierProduct->status==1) selected @endif >Active</option>
                                        <option value="0" @if($supplierProduct->status==0) selected @endif>Inactive</option>
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
<script src="{{asset('js/select2.min.js')}}"></script>

<script>
$(document).ready(function(){
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $("#raw_material_category_id").change(function(e){
        e.preventDefault();
        var supplier_code=$('#supplier_id').val();
        var rm_category=$('#raw_material_category_id').val();
        $.ajax({
            url: "{{ route('rmcategorydata') }}?id=" + $(this).val(),
            method: 'GET',
            cache:false,
            processData:false,
            contentType:false,
            success : function(result){
                console.log(result);
                if (result.count > 0) {
                    $('#raw_material_id').html(result.rm);
                }
            }
        });
	});
});
</script>
@endsection