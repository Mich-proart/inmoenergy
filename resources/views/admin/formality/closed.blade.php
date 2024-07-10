@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tramites cerrados</h1>
@stop

@section('content')

<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{Auth::user()->name}}</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                <thead>
                    <tr>
                        <th>Cliente emisor</th>
                        <th>Fecha</th>
                        <th>Usuario asignado</th>
                        <th>Tipo</th>
                        <th>Suministro</th>
                        <th>Nombre</th>
                        <th>Tipo documento</th>
                        <th>N documento</th>
                        <th>Dirección</th>
                        <th>Fecha Finalizacion del tramite</th>
                        <th>Estado Tramite</th>
                        <th>Compañía Suministro</th>
                        <th>Producto Compañía</th>
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
    const table = new DataTable('#formality-content', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('api.formality.index')}}",
            "type": "GET",
            "data": {
                "issuerId": "{{Auth::id()}}",
                "onlyStatus": ["tramitado", "en vigor"]
            }
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "columns": [
            { data: 'issuer' },
            { data: 'created_at' },
            { data: 'assigned' },
            { data: 'type' },
            { data: 'service' },
            { data: 'fullName' },
            { data: 'document_type' },
            { data: 'documentNumber' },
            { data: 'fullAddress' },
            { data: 'completion_date' },
            { data: 'status' },
            { data: 'company' },
            { data: 'product' },
        ],
        "columnDefs": [
            {
                "render": function (data, type, row) {
                    return `<span class="badge rounded-pill bg-info text-dark">${data}</span>`;
                },
                "targets": 9
            },
            { className: "dt-head-center", targets: [0] },
            { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 7, 9, 10, 11, 12] }
        ],
        "order": [
            [0, "desc"]
        ],
    });

    $('#formality-content').on('click', 'tbody tr', function () {
        const row = table.row(this).data();
        console.log(row);
        window.location.href = "{{ route('admin.formality.get', ':id') }}".replace(':id', row.formality_id);
    })
</script>

@stop