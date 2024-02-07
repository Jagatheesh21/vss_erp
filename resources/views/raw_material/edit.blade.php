@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex text-center" style="justify-content:space-around"><b>Material Updation</b><a href="{{route('raw_material.index')}}" class="btn btn-sm btn-primary">Material List</a></div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success mt-4">
                    {{ Session::get('success')}}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger mt-4">
                    {{ Session::get('error')}}
                    </div>
                @endif
                <div class="row col-md-3"id="res"></div>

                <form action="{{route('raw_material.update',$rawMaterial->id)}}" id="raw_material_formdata" method="POST">
                    @csrf
                    @method('PUT')
                  <input type="hidden" name="id" value="{{$rawMaterial->id}}">

                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="raw_material_category_id">Category *</label>
                                <select name="raw_material_category_id" id="raw_material_category_id" class="form-control">
                                    <option value=""></option>
                                    @forelse ($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id==$rawMaterial->raw_material_category_id) selected @endif>{{$category->name}}</option>
                                    @empty

                                    @endforelse
                                </select>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Material Description *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$rawMaterial->name}}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Material Code *</label>
                                <input type="text" name="material_code"  value="{{$rawMaterial->material_code}}" readonly class="form-control bg-light @error('material_code') is-invalid @enderror" >
                                @error('material_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Minimum Stock *</label>
                                <input type="number" name="minimum_stock" min="0.10" step="0.01" value="{{$rawMaterial->minimum_stock}}" class="form-control @error('minimum_stock') is-invalid @enderror" >
                                @error('minimum_stock')
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
                                <label for="maximum_stock">Maximum Stock *</label>
                                <input type="number" name="maximum_stock" min="0.10" step="0.01" value="{{$rawMaterial->maximum_stock}}" class="form-control @error('maximum_stock') is-invalid @enderror" >
                                @error('maximum_stock')
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
                                    <option value="1" @if($rawMaterial->status==1) selected @endif >Active</option>
                                    <option value="0" @if($rawMaterial->status==0) selected @endif>Inactive</option>
                                </select>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center ">
                        <div class="col-md-2 mt-4">
                            <input type="submit" class="btn btn-success  text-white align-center" id="btn" value="Save">
                            <input class="btn btn-danger text-white" id="reset" type="reset" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}" ></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#raw_material_category_id").select2();

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $("#raw_material_formdata").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#raw_material_formdata")[0]);
            $("#btn").attr('disabled',true);
            $("#btn").val('Updating...');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Add it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                                    // url: editUrl,
                    url: this.action,
                    type:"POST",
                    data: formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                    success: function(data) {
                    if (data.code==404||data.code==500) {
                        let error ='<span class="alert alert-danger">'+data.msg+'</span>';
                            $("#res").html(error);
                                    // $("#btn").attr('disabled',false);
                                    // $("#btn").val('Save');
                    }else{
                        //    console.log(data);
                        $("#btn").attr('disabled',false);
                        $("#btn").val('Save');
                        swalWithBootstrapButtons.fire(
                            'Updated!',
                            'Raw Material is Updated Successfully!...',
                            'success'
                            );
                            location.reload(true);
                        }
                    }
                });
                                // ajax request completed
            }else if (
             /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
                ) {
                    $("#btn").attr('disabled',false);
                    $("#btn").val('Save');
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your Raw Material Data is safe',
                    'error'
                    )
                }
            });
        });
        $("#reset").click(function (e) {
            e.preventDefault();
            location.reload(true);
        });
    });
    </script>
    @endsection
