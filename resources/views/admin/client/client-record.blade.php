@extends('adminlte::page')

@section('title', 'Ver o editar ficha cliente')

@section('meta_tags')
<meta name="version" content="{{ config('app.version') }}">
@stop

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
        <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
            class="img-thumbnail align-self-center resize">
        <h3>{{ucfirst($program->name)}}</h3>
        @section('title', ucfirst($program->name))
        @endif
    </div>
</div>
@stop


@section('content')
@livewire('client.view-edit-client-record')
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
<link href="{{ asset('css/custom-focus.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
<style>
    .client-data-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .address-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .address-item {
        cursor: pointer;
        padding: 10px;
        border: 1px solid #dee2e6;
        margin-bottom: 5px;
        border-radius: 3px;
        transition: background-color 0.2s;
    }

    .address-item:hover {
        background-color: #e9ecef;
    }

    .address-item.active {
        background-color: #d4edda;
        border-color: #28a745;
    }

    .form-control:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('client-updated', (event) => {
            Swal.fire({
                icon: "success",
                title: event.title,
                text: event.message,
                showConfirmButton: false,
                timer: 1500
            });
        });

        Livewire.on('client-error', (event) => {
            Swal.fire({
                icon: "error",
                title: event.title,
                text: event.message,
            });
        });

        Livewire.on('address-updated', (event) => {
            Swal.fire({
                icon: "success",
                title: event.title,
                text: event.message,
                showConfirmButton: false,
                timer: 1500
            });
        });

        Livewire.on('address-error', (event) => {
            Swal.fire({
                icon: "error",
                title: event.title,
                text: event.message,
            });
        });
    });
</script>
@stop