@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tramites cerrados</h1>
@stop

@section('content')

<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{Auth::user()->name}}</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="formality-content" class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario asignado</th>
                        <th>Tipo</th>
                        <th>Suministro</th>
                        <th>Nombre</th>
                        <th>1 Apellido</th>
                        <th>2 Apellido</th>
                        <th>Tipo document</th>
                        <th>N documento</th>
                        <th>Tipo Calle</th>
                        <th>Nombre Calle</th>
                        <th>N calle</th>
                        <th>Bloque</th>
                        <th>Escalera</th>
                        <th>Piso</th>
                        <th>Puerta</th>
                        <th>Fecha Finalizacion del tramite</th>
                        <th>Estado Tramite</th>
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
    new DataTable('#formality-content', {
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
            { data: 'created_at' },
            { data: 'assigned' },
            { data: 'type' },
            { data: 'service' },
            { data: 'name' },
            { data: 'firstLastName' },
            { data: 'secondLastName' },
            { data: 'document_type' },
            { data: 'documentNumber' },
            { data: 'street_type' },
            { data: 'street_name' },
            { data: 'street_number' },
            { data: 'block' },
            { data: 'block_staircase' },
            { data: 'floor' },
            { data: 'door' },
            { data: 'completion_date' },
            { data: 'status' },
        ],
        "columnDefs": [
            {
                "render": function (data, type, row) {
                    return `<span class="badge rounded-pill bg-info text-dark">${data}</span>`;
                },
                "targets": 17
            },
            { className: "dt-head-center", targets: [0] },

            { className: "dt-body-center", targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17] }
        ]
    });
</script>

@stop