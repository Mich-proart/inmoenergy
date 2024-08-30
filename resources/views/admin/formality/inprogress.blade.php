@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        <img src="{{ '/vendor/adminlte/dist/img/icons/' . 'in_progress_formality.png' }}" alt=""
            class="img-thumbnail align-self-center resize">
        <h3>Trámites en curso</h3>
    </div>
</div>
@stop

@section('content')

@livewire('formality.in-progress-layout')


@stop

@section('css')
{{-- Add here extra stylesheets --}}
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">

@stop

@section('js')


@stop