@extends('master')

@section('content')
<div class="container mt-5">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <a href="companies/create" class="btn btn-primary pull-right">Add New Company</a>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Logo</th>
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
            ajax: "{{ route('companies.getcompanies') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'logo', name: 'logo',
                    render: function( data, type, full, meta ) {
                        return "<img src=\"/storage/" + data + "\" height=\"50\"; width=\"50\"/>";
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

    function deletecompany(id) {   
            $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/companies/'+id,
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