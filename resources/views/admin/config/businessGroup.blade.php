@extends('adminlte::page')

@section('title', 'Grupo empresarial')

@section('meta_tags')
<meta name="version" content="{{ config('app.version') }}">
@stop

@section('content_header')
<h1>Grupo empresarial</h1>
@stop

@section('content')

<div>
    <livewire:config.create-business-group-modal />
</div>


@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
<link href="{{ asset('css/custom-focus.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>


@stop