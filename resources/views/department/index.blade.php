@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">

    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex" style="justify-content:space-between"><span> Department List </span>
            <a class="btn btn-sm btn-primary" href="{{route('department.create')}}">Add Department</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="departments-table" class="table table-bordered table-responsive table-striped table-nowrap" >
                        <thead>
                            <tr>
                                <th>SNo</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
            var table = $('#departments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('department.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });
        $(document).on('click','.deleteDepartment',function(){
            if(!confirm("Are you sure?")) return;
        });
    </script>
@endpush
