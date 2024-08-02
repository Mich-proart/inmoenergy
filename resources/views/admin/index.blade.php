@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . 'dashboard.png') }}" alt=""
            class="img-thumbnail align-self-center resize">
        <h3>Panel de control</h3>
    </div>
</div>
@stop
@section('content')
<div>
    <div class="card">
        <div class="card-body">


            <div class="container">
                @if (isset($sections))
                    @foreach ($sections as $section)
                        @if ($section->programs->count() > 0)
                            <div class="row mr-2">
                                <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst($section->name) }}</h6>
                                <hr>
                                @foreach ($section->programs as $program)
                                    <div class="col-md-2">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="d-inline-flex position-relative">
                                                <a href="{{route($program->route)}}">
                                                    @if ($program->count > 0)
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                            {{$program->count}}
                                                            <span class="visually-hidden">unread messages</span>
                                                        </span>

                                                    @endif
                                                    <img src="{{'/vendor/adminlte/dist/img/icons/' . $program->image}}" alt=""
                                                        class="img-thumbnail align-self-center">
                                                </a>
                                            </div>

                                        </div>
                                        <a href="{{route($program->route)}}">
                                            <p class="fw-bolder text-center">{{ucfirst($program->name)}}</p>
                                        </a>

                                    </div>

                                @endforeach
                            </div>

                        @endif
                    @endforeach
                @endif

            </div>

        </div>
    </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
@stop