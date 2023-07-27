@extends('master')

@section('content')
<div class="container mt-5">
    <a href="employees/create" class="btn btn-primary pull-right">Add New Employee</a>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>company</th>
                <th>Image</th>                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(function () {
        
        var table = $('.yajra-datatable').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{ route('employees.getemplyees') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'company', name: 'company'},
                {data: 'image', name: 'image',
                    render: function( data, type, full, meta ) {
                        return "<img src=\"/storage/" + data + "\" height=\"50\";  width=\"50\"/>";
                    }
                },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
        
    });

    function deleteemployee(id) {   
            $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/employees/'+id,
                type: 'POST',
                data: {
                    '_method': 'delete'
                  },
                success: function (){
                    location.reload();
                }
            });
            }
    </script>
@endsection