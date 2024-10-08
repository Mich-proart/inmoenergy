@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
            <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
                class="img-thumbnail align-self-center resize">
            <h3>{{ucfirst($program->name)}}</h3>
        @endif
    </div>
</div>
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
                        <th>Fecha de entrada</th>
                        <th>Usuario asignado</th>
                        <th>Tipo</th>
                        <th>Suministro</th>
                        <th>Cliente final</th>
                        <th>N documento</th>
                        <th>Dirección</th>
                        <th>Fecha Finalizacion del tramite</th>
                        <th>Estado trámite</th>
                        <th>Compañía suministro</th>
                        <th>Observaciones asesor</th>
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="/vendor/custom/badge.code.js"></script>
<script>
    const table = new DataTable('#formality-content', {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: `Tramites cerrados - ${new Date()}`
            }
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('api.formality.closed')}}",
            "type": "GET",
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
            { data: 'documentNumber' },
            { data: 'fullAddress' },
            { data: 'completion_date' },
            {
                data: 'status', render: function (data, type, row, meta) {
                    return statusColor(data);
                }
            },
            { data: 'company' },
            { data: 'assigned_observation' },
        ],
        "columnDefs": [
            { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
            { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 7, 8] }
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