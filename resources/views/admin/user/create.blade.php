@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
            <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
                class="img-thumbnail align-self-center resize">
            @if (isset($content) && $content == 'worker')
                <h3>Nuevo usuario</h3>
            @else
                <h3>Nuevo cliente</h3>
            @endif
        @endif
    </div>
</div>
@stop

@section('content')

@section('plugins.Select2', true)

@if (isset($content) && $content == 'worker')
    @livewire('user.create-user-form', ['isWorker' => true])
@else
    @livewire('user.create-user-form', ['isWorker' => false])
@endif



@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.3.2/build/css/intlTelInput.css">
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />

@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.3.2/build/js/intlTelInput.min.js"></script>
@stop