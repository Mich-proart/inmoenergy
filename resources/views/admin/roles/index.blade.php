@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard Inmoenergy</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Role</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <th scope="row">{{ $role->id }}</th>
                        <td>{{ $role->name }}</td>
                        <td width="10px">
                            <a href="{{route('admin.roles.edit', $role)}}" class="btn btn-primary">Editar</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
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