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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
<div>

    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3">
            <div class="col-12 ">

            </div>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Usuario asignado: </label> @if (isset($ticket->assigned))
                                {{$ticket->assigned->name}} {{ " " . $ticket->assigned->first_last_name}}
                                {{ " " . $ticket->assigned->second_last_name}}
                            @endif
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Fecha de entrada:</label> {{$ticket->created_at}}
                        </div>
                        <div id="status" class="col-sm-4 invoice-col">
                            <x-badge.status :status="$ticket->status" />
                        </div>
                    </div>

                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Título ticket: </label>
                            {{ucfirst($ticket->ticket_title)}}
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Fecha resolución ticket:</label>
                            {{ucfirst($ticket->resolution_date)}}
                        </div>
                        <div id="status" class="col-sm-4 invoice-col">
                            <x-badge.resolved-ticket-label :isResolved="$ticket->isResolved" />
                        </div>
                    </div>

                </div>
            </section>

            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Tipo de ticket: </label> @if (isset($ticket->type))
                                {{ucfirst($ticket->type->name)}}
                            @endif
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Suministro tramitado: </label> @if (isset($ticket->formality->service))
                                {{ucfirst($ticket->formality->service->name)}}
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                    <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                        Datos del Cliente
                    </span>
                </div>
                @if (isset($ticket->formality->client))
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Tipo Cliente: </label>
                            @if (isset($ticket->formality->client->clientType))
                                {{ucfirst($ticket->formality->client->clientType->name)}}
                            @endif
                        </div>
                        <div class="form-group col-md-1">
                            <label for="inputState">Título: </label> @if (isset($ticket->formality->client->title))
                                {{ucfirst($ticket->formality->client->title->name)}}
                            @endif
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputCity">Nombre</label> {{ucfirst($ticket->formality->client->name)}}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputState">Primer apellido: </label>
                            {{ucfirst($ticket->formality->client->first_last_name)}}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputZip">Segundo apellido: </label>
                            {{ucfirst($ticket->formality->client->second_last_name)}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputState">Tipo documento: </label>
                            @if (isset($ticket->formality->client->documentType))
                                {{ucfirst($ticket->formality->client->documentType->name)}}
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputState">Número documento: </label>
                            {{$ticket->formality->client->document_number}}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Teléfono: </label> {{$ticket->formality->client->phone}}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputZip">Email: </label> {{$ticket->formality->client->email}}
                        </div>
                    </div>

                    <div class=" form-group">
                        <label for="inputAddress2">Cuenta Bancaria: </label> {{$ticket->formality->client->IBAN}}
                    </div>
                @endif
            </section>
            @if (isset($ticket->formality->address))
                <section>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Dirección de suministro
                        </span>
                    </div>

                    <!-- street group -->
                    <div class="row">
                        <!-- street type -->
                        <div class="col-md-2">
                            <label for="inputZip">Tipo de calle: </label>
                            @if (isset($ticket->formality->address->streetType))
                                {{ucfirst($ticket->formality->address->streetType->name)}}
                            @endif
                        </div>
                        <!-- street name -->
                        <div class="col-md-2">
                            <label for="inputZip">Nombre calle: </label>
                            @if (isset($ticket->formality->address->street_name))
                                {{ucfirst($ticket->formality->address->street_name)}}
                            @endif
                        </div>
                        <!-- street number -->
                        <div class="col-md-1">
                            <label for="inputZip">N°: </label> {{$ticket->formality->address->street_number}}
                        </div>
                        <!-- block -->
                        <div class="col-md-1">
                            <label for="inputZip">Bloque: </label> {{$ticket->formality->address->block}}
                        </div>
                        <!-- staircase -->
                        <div class="col-md-1">
                            <label for="inputZip">Escalera: </label> {{$ticket->formality->address->block_staircase}}
                        </div>
                        <!-- floor -->
                        <div class="col-md-1">
                            <label for="inputZip">Piso: </label> {{$ticket->formality->address->floor}}
                        </div>
                        <!-- door -->
                        <div class="col-md-1">
                            <label for="inputZip">Puerta: </label> {{$ticket->formality->address->door}}
                        </div>
                        <!-- housing -->
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Tipo de vivienda: </label>
                            @if (isset($ticket->formality->address->housingType))
                                {{ucfirst($ticket->formality->address->housingType->name)}}
                            @endif
                        </div>
                    </div>
                </section>
            @endif
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripción ticket</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"
                        @readonly(true)>{{$ticket->ticket_description}}</textarea>
                </div>

            </div>
            @livewire('ticket.get-comments', ['ticket' => $ticket])
        </div>
    </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/custom/badge.code.js"></script>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    $(document).ready(function () {
        function statuscode(code) {
            return statusColor(code);
        }

    });
</script>
@stop