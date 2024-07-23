@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@if (isset($program))
    <h1>{{ucfirst($program->name)}}</h1>
@endif
@stop

@section('content')

<div>
    <div class="card card-primary card-outline">
        <div class="card-body table-responsive p-0">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Archivo</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($program))
                            @foreach ($program->files as $file)
                                <tr>
                                    <td>{{$file->name}}</td>
                                    <td>
                                        <a href="{{route('admin.documents.download', $file->id)}}">
                                            <button class="btn btn-primary btn-sm">Descargar</button></a>
                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
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
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>


@stop