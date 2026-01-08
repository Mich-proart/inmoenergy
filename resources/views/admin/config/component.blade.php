@extends('adminlte::page')


@section('meta_tags')
<meta name="version" content="{{ config('app.version') }}">
@stop

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
    <div class="card card-success card-outline">
        <div class="card-header">
            <div class="row no-print">
                <div class="col-12">
                    <div>
                        <h3 class="card-title">{{Auth::user()->name}}</h3>
                        <a href="{{ route('admin.config.businessGroup') }}">
                            <button type="button" class="btn btn-success float-right btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg> Ver grupo empresarial
                            </button>
                        </a>
                        <a href="{{route('admin.config.documents')}}"><button type="button"
                                class="btn btn-success float-right btn-sm mr-1">Documentos</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="component-content" class="table table-hover text-nowrap" style="cursor:pointer">
                <thead>
                    <tr>
                        <th>Nombre de desplegables</th>
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
<link href="{{ asset('css/custom-focus.css') }}" rel="stylesheet">
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

<script>
    const table = new DataTable('#component-content', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('api.component.query')}}",
            "type": "GET",
            "data": {
            }
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "columns": [
            { data: 'component_name' },

        ],
        "columnDefs": [
            { className: "text-left", targets: "_all" },
            { className: "text-capitalize", targets: "_all" }
        ],
        "order": [
            [0, "desc"]
        ],
    });

    $('#component-content').on('click', 'tbody tr', function () {
        const row = table.row(this).data();
        console.log(row);
        window.location.href = "{{ route('admin.component.details', ':id') }}".replace(':id', row.id);
    })
</script>

@stop