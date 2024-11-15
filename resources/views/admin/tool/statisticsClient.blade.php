@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-6 image-text-container">
            @if (isset($program))
                <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
                     class="img-thumbnail align-self-center resize">
                <h3>{{ucfirst($program->name)}}</h3>
            @endif
        </div>
    </div>
@stop

@section('content')
    <div>
        <div class="card card-primary card-outline" style="height: 500px">
            <div class="card-body table-responsive p-0">
                @livewire('tool.filter', ['searchBasedOn' => 'user_issuer_id'])
                @livewire('tool.charts')
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{--
    <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@stop
