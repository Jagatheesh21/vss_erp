@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> Create PO Correction</span>
                <a class="btn btn-sm btn-primary" href="{{route('po.index')}}">PO List</a>
            </div>
            <div class="row col-md-3"id="res"></div>

            <div class="card-body">

                    <form action="{{route('po-correction.store')}}" id="pocorrection_formdata"  method="POST">
                        @csrf
                        @method('POST')
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="po_id">PO Number *</label>
                                    <select name="po_id" id="po_id" class="form-control bg-light @error('po_id') is-invalid @enderror">
                                    @forelse ($po_datas as $po_data)
                                        <option name="po_id" value="{{$po_data->id}}" selected>{{$po_data->ponumber}}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                    @error('po_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="po_corrections_date">Date *</label>
                                    <input type="date" name="po_corrections_date" class="form-control bg-light @error('po_corrections_date') is-invalid @enderror" readonly value="{{date('Y-m-d')}}">
                                    @error('po_corrections_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    @forelse ($po_datas as $po_data)
                                    <input type="text" name="name" class="form-control  bg-light @error('name') is-invalid @enderror" value="{{$po_data->supplier->name}}" readonly >
                                    @empty
                                    @endforelse
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Total Amount *</label>
                                    <input type="Number" name="rate" class="form-control  bg-light @error('rate') is-invalid @enderror" value="{{$total_rate}}" readonly >
                                    @error('rate')
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
                                    <label for="request_reason">REASON *</label>
                                    <textarea name="request_reason" id="request_reason" class="form-control @error('request_reason') is-invalid @enderror" cols="20" rows="3"></textarea>
                                    @error('request_reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="approved_by">Approved BY *</label>
                                    <select name="approved_by" id="approved_by" class="form-control bg-light @error('approved_by') is-invalid @enderror" disabled>
                                    <option value=""></option>
                                        <option value="{{$user_datas->id}}" selected>{{$user_datas->name}}</option>
                                    </select>
                                    @error('approved_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        <div class="row d-flex justify-content-center ">
                            <div class="col-md-2 mt-4">
                                <input type="submit" class="btn btn-success  text-white align-center" id="btn" value="Request">
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
        $("#pocorrection_formdata").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($("#pocorrection_formdata")[0]);
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
                            'PO Correction is Request Submitted Successfully!...',
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
                    'PO Correction Data is safe',
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
