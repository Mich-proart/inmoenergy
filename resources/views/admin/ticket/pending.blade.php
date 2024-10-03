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

    <div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="ticket-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Dirección</th>
                            <th>Fecha emisión ticket</th>
                            <th>Tipo</th>
                            <th>Título ticket</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                </table>
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    const table = new DataTable('#ticket-content', {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: `Ticket pendientes - ${new Date()}`
            }
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('api.ticket.pending')}}",
            "type": "GET",
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "columns": [
            { data: 'service' },
            { data: 'fullName' },
            { data: 'fullAddress' },
            { data: 'created_at' },
            { data: 'type' },
            { data: 'ticket_title' },
            {
                data: 'status', render: function (data, type, row, meta) {
                    return statusColor(data);
                }
            },

        ],
        "columnDefs": [
            { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 6] },
            { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 6] }
        ],
        "order": [
            [3, "desc"]
        ],
    });

    $('#ticket-content').on('click', 'tbody tr', function () {
        const row = table.row(this).data();
        console.log(row);
        window.location.href = "{{ route('admin.ticket.edit', ':id') }} ".replace(':id', row.ticket_id);
    })

</script>
@stop