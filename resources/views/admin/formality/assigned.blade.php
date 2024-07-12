@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tramites asignados</h1>
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
                        <th>Fecha</th>
                        <th>Usuario asignado</th>
                        <th>Tipo</th>
                        <th>Suministro</th>
                        <th>Ciente final</th>
                        <th>Tipo documento</th>
                        <th>N documento</th>
                        <th>Dirección</th>
                        <th>Estado Tramite</th>
                        <th>Tramite Critico</th>
                        <th>Observaciones del tramite</th>
                        <th>Compañía Suministro</th>
                        <th>Producto Compañía</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" id="tigger_modal" data-bs-toggle="modal"
        data-bs-target="#exampleModal" hidden>
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-bold"> ¿Quieres abrir este trámite? Al abrir iniciará su proceso de tramitación. </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="trigger_formality">Si</button>
                </div>
            </div>
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
                "assignedId": "{{Auth::id()}}",
                "exceptStatus": ["tramitado", "en vigor"]
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
            { data: 'fullName' },
            { data: 'document_type' },
            { data: 'documentNumber' },
            { data: 'fullAddress' },
            { data: 'status' },
            {
                data: 'isCritical', render: function (data, type, row, meta) {
                    if (data == 0) {
                        return `<div><i class="fas fa-times"></i></div>`;
                    } else {
                        return `<div><i class="fas fa-check"></i></div>`
                    }
                }
            },
            { data: 'observation' },
            { data: 'company' },
            { data: 'product' },
        ],
        "columnDefs": [
            {
                "render": function (data, type, row) {
                    return `<span class="badge rounded-pill bg-info text-dark">${data}</span>`;
                },
                "targets": 8
            },
            { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 7, 8, 11, 12] },
            { className: "text-capitalize", targets: [1, 2, 3, 4, 5, 7, 8, 11, 12] }
        ],
        "order": [
            [0, "desc"]
        ],
    });

    let formality_id = 0;
    $('#formality-content').on('click', 'tbody tr', function () {
        const row = table.row(this).data();
        formality_id = row.formality_id;
        console.log(row);
        $('#tigger_modal').click();
    })

    $('#trigger_formality').on('click', function () {
        window.location.href = "{{ route('admin.formality.modify', ':id') }}".replace(':id', formality_id);
    })
</script>

@stop