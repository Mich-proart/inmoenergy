@extends('adminlte::page')


@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
            <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
                class="img-thumbnail align-self-center resize">
            <h3>{{ucfirst($program->name)}}</h3>
            @section('title', ucfirst($program->name))
        @endif
    </div>
</div>
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
                        <button type="submit" onclick="addQueryParam()" class="btn btn-primary float-right btn-sm"><i
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
                        <th>Estado</th>
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
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="/vendor/custom/user.status.js"></script>

<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
    const table = new DataTable('#user-content', {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: `Gestión de usuarios - ${new Date()}`
            }
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('api.user.query')}}",
            "type": "GET",
            "data": {
                "isClient": "false"
            }
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "columns": [
            { data: 'created_at' },
            { data: 'fullName' },
            { data: 'fullAddress' },
            {
                data: 'isActive', render: function (data, type, row, meta) {
                    return userStatusCode(data);
                }
            },
        ],
        "columnDefs": [
            { className: "dt-head-center", targets: [0, 1, 2, 3] },
            { className: "text-capitalize", targets: [1, 2, 3] }
        ],
        "order": [
            [0, "desc"]
        ],
    });


    $('#user-content').on('click', 'tbody tr', function () {
        const row = table.row(this).data();
        let url = "{{ route('admin.users.edit', ':id') }}".replace(':id', Number(row.user_id));
        url = new URL(url);
        let params = new URLSearchParams(url.search);
        params.set('content', 'worker');
        url.search = params.toString();
        window.location.href = url.toString();
    })


</script>
<script>
    function addQueryParam() {
        var url = new URL('{{ route('admin.users.create') }}');
        var params = new URLSearchParams(url.search);
        params.set('content', 'worker');
        url.search = params.toString();
        window.location.href = url.toString();
    }

</script>
@stop