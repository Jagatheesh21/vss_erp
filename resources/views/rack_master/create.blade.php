@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-8 ">
        <div class="card " >

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
        <div class="card-header d-flex justify-content-space-around">
            <div class="col-md-8"><b>Create Rack Master</b></div>
            <div class="col-md-4"><a class="btn btn-sm btn-primary" href="{{route('rackmaster.index')}}">Rack Master List</a></div>
        </div>
        <div class="row col-md-3"id="res"></div>

            <div class="card-body">
            <form action="{{route('rackmaster.store')}}" id="rack-master_formdata" method="POST">
                @csrf
                @method('POST')

                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stocking_id">Storage Area *</label>
                            <select name="stocking_id" id="stocking_id" class="form-control @error('stocking_id') is-invalid @enderror">
                                <option value=""></option>
                                @forelse ($rackstockmasters as $rackstockmaster)
                                    <option value="{{$rackstockmaster->id}}">{{$rackstockmaster->name}}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('stocking_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rack_name">Rock ID *</label>
                            <input type="text" name="rack_name" class="form-control @error('rack_name') is-invalid @enderror" >
                            @error('rack_name')
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
                                    <option value="{{$category->id}}">{{$category->name}}</option>
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
                            <select name="raw_material_id" id="raw_material_id" class="form-control @error('raw_material_id') is-invalid @enderror"></select>
                            @error('raw_material_id')
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
        $("#stocking_id").select2();
        $("#raw_material_category_id").select2();

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $("#raw_material_category_id").change(function(e){
            e.preventDefault();
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
                        $("#stocking_id").select2();
                        $("#raw_material_id").select2();
                        $('#raw_material_id').html(result.rm);
                        $("#raw_material_category_id").select2();
                    }
                }
            });
        });
        $("#rack-master_formdata").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#rack-master_formdata")[0]);
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
                        // console.log(data);
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
                            'Stocking Point Rack Master is Created Successfully!...',
                            'success'
                            );
                            // location.reload(true);
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
                    'Your Department Data is safe',
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
