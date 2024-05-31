@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tramites en curso</h1>
@stop

@section('content')

<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{Auth::user()->name}}</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Asignado</th>
                        <th>Tipo</th>
                        <th>Suministro</th>
                        <th>Cliente</th>
                        <th>Tipo documento</th>
                        <th>Documento</th>
                        <th>Direccion</th>
                        <th>Estado </th>
                        <th>Observaciones</th>
                        <th>Compañia</th>
                        <th>Productor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05-05-2019: 05:00 PM</td>
                        <td>John Doe</td>
                        <td>nuevo tramite</td>
                        <td>luz</td>
                        <td>Steve Roguers</td>
                        <td>DNI</td>
                        <td>000000000</td>
                        <td>Ibina, Barcelona</td>
                        <td><span class="badge badge-info">en vigor</span></td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>inmoegergy</td>
                        <td>energy</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="#">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a>
                            <a class="btn btn-info btn-sm" href="#">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop