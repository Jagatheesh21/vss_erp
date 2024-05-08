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
            <div class="card-header d-flex" style="justify-content:space-between"><span><b>Return RM List</b>  </span>
                <a class="btn btn-md btn-primary" href="{{route('retrunrmdetails.create')}}"><b><i class='bx bx-plus bx-flashing' style='color:white;' ></i>&nbsp;&nbsp; New</b></a>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Route Card Number</th>
                                    <th>Return Date</th>
                                    <th>Part Number</th>
                                    <th>GRN Number</th>
                                    <th>RM Desc</th>
                                    <th>Heat Number</th>
                                    <th>Coil Number</th>
                                    <th>Test Certificate Number</th>
                                    <th>Before Return Qty</th>
                                    <th>Return Qty</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($returnrmDatas as $returnrmData)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
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
