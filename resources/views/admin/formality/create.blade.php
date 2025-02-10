@extends('adminlte::page')

@section('title', 'Nuevo trámite')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        <img src="{{ '/vendor/adminlte/dist/img/icons/' . 'create_formality.png' }}" alt=""
            class="img-thumbnail align-self-center resize">
        <h3>Nuevo trámite</h3>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@stop

@section('content')
<div>

    <livewire:formality.create-by-client />

</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'spinner.css') }}" rel="stylesheet" />
<style>
    .dropdown-menu {
        max-height: 200px;
        overflow-y: scroll;
    }
</style>
@stop

@section('js')


{{-- File Pond Jquerys Cdn --}}

{{-- File Pond Image Preview Cdn --}}
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop