@extends('layouts.app')
@section('content')
<link  rel="stylesheet" href="{{asset('node_modules/boxicons/css/boxicons.min.css')}}" />

<div class="row d-flex justify-content-center">
    <div class="col-12">
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
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Semi Finished Store Receive Register List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('sfreceive.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Date</th>
                                    <th>Operation</th>
                                    <th>Part Number</th>
                                    <th>Route Card Number</th>
                                    <th>Previous Route Card Number</th>
                                    <th>Receive Qty</th>
                                    <th>Received By</th>
                                    <th>Received Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($d12Datas as $d12Data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$d12Data->open_date}}</td>
                                    <td>{{$d12Data->operation}}</td>
                                    <td>{{$d12Data->part_no}}</td>
                                    <td>{{$d12Data->rc_no}}</td>
                                    <td>{{$d12Data->previous_rc_no}}</td>
                                    <td>{{$d12Data->receive_qty}}</td>
                                    <td>{{$d12Data->user_name}}</td>
                                    <td>{{$d12Data->created_at}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="18" align="center">No Records Found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/boxicons.js')}}"></script>
@endsection
