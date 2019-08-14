@extends('layouts.backend.index')
@section('content')
<div class="page-header">
      <h1 class="page-title">Users Management</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users Management</li>
      </ol>
</div>

<div class="page-content">
<div class="panel">
        <div class="panel-body">
          <table class="table table-hover table-striped w-full" id="users-table">
            <thead>
              <tr>
                <th>Sl.no</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email ID</th>
                <th>Is Active</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#users-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('admin.users.getData') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status'},
                // {data: 'status', name: 'status', render: function ( data, type, row, meta ) {
                //         if(data == 'active'){
                //             return '<span class="badge badge-success">Active</span>';
                //         } else {
                //             return '<span class="badge badge-danger">Inactive</span>';
                      
                //         }
                //     }
                // }
            ]
        });
    });
</script>
@endsection