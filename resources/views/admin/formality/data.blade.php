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
    <div>
        <div class="card card-success card-outline">
            <div class="card-body table-responsive p-0">
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="" scope="col">Archivo</th>
                                <th class="text-center" scope="col">Cantidad de registros</th>
                                <th class="text-center" scope="col">Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ucfirst($program->name)}}</td>
                                <td class="text-center">
                                    @isset($count)
                                        {{$count}}
                                    @endisset
                                </td>
                                <td class="text-center">
                                    <button id="csvDownload" class="btn btn-primary btn-sm" type="button">
                                        archivo .CSV
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/custom/data.handle.js"></script>
<script>
    $(document).ready(async function () {
        let csv = '';
        try {
            const response = await fetch("{{route('admin.formality.fetch')}}", { method: 'GET', });
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const data = await response.json();
            csv = handle(data);
        } catch (error) {

        }
        $('#csvDownload').click(function () {
            csvDownload(csv, 'datos_trámites_inmoenergy');
        })
    });
</script>
@stop