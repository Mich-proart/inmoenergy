@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
            <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
                class="img-thumbnail align-self-center resize">
            @if (isset($content) && $content == 'worker')
                <h3>Editar usuario</h3>
            @else
                <h3>Editar cliente</h3>
            @endif
        @endif
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
<div>

    @if (isset($userId))
        <livewire:user.edit-user-form :userId="$userId" />
    @endif

</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop