@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> Create RawMaterialCategory</span>
                <a class="btn btn-sm btn-primary" href="{{route('raw_material_category.index')}}">Category List</a>
            </div>
            <div class="row col-md-3"id="res"></div>

            <div class="card-body">

                    <form action="{{route('raw_material_category.store')}}" id="raw_material_category_formdata"  method="POST">
                        @csrf
                        @method('POST')
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" >
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
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $("#raw_material_category_formdata").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#raw_material_category_formdata")[0]);
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
                            'Added!',
                            'Raw Material Category is Created Successfully!...',
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
                    'Your Raw Material Category Data is safe',
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
