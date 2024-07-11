@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Gestión de usuarios</h1>
@stop

@section('content')

<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row no-print">
                <div class="col-12">
                    <div>
                        <h3 class="card-title">{{Auth::user()->name}}</h3>
                        @role('superadmin')
                        <button type="submit" onclick="addQueryParam()" class="btn btn-primary float-right"><i
                                class="far fa-plus-square"></i>
                            Agregar usuario</button>
                        @endrole

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="user-content" class="table table-hover text-nowrap" style="cursor:pointer">
                <thead>
                    <tr>
                        <th>Fecha de registro</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>
</div>


@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>
    const table = new DataTable('#user-content', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('api.user.query')}}",
            "type": "GET",
            "data": {
                "isClient": "true"
            }
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "columns": [
            { data: 'created_at' },
            { data: 'fullName' },
            { data: 'fullAddress' },
        ],
        "columnDefs": [
            { className: "dt-head-center", targets: [0, 1, 2] },
            { className: "text-capitalize", targets: [1, 2] }
        ],
        "order": [
            [0, "desc"]
        ],
    });


    $('#user-content').on('click', 'tbody tr', function () {
        const row = table.row(this).data();
        console.log(row);
        window.location.href = "{{ route('admin.users.edit', ':id') }}".replace(':id', Number(row.user_id));
    })


</script>
<script>
    function addQueryParam() {
        var url = new URL('{{ route('admin.users.create') }}');
        var params = new URLSearchParams(url.search);
        params.set('content', 'client');
        url.search = params.toString();
        window.location.href = url.toString();
    }

</script>
@stop