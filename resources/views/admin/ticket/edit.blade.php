@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
            <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
                class="img-thumbnail align-self-center resize">
            <h3>Ticket</h3>
        @endif
    </div>
</div>
@stop

@section('content')
<div>

    <div>
        <div class="card card-primary card-outline">
            <div class="card-body table-responsive p-0">
                <div class="container mb-6 mt-6">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-row" style="margin-top: 30px; margin-bottom: 20px">
                                <span style="font-size: 20px;"><i class="fas fa-file-invoice"></i>
                                    Trámite
                                </span>
                            </div>
                            <ul class="list-unstyled">
                                <li class="text"><span class="fw-bold">Suministro:</span>
                                    @empty(!$ticket->formality->service)
                                        {{ ucfirst($ticket->formality->service->name) }}
                                    @endempty
                                </li>
                                <li class="text"><span class="fw-bold">Nombre cliente final: </span>
                                    @empty(!$ticket->formality->client)
                                        {{ ucfirst($ticket->formality->client->name . ' ' . $ticket->formality->client->first_last_name . ' ' . $ticket->formality->client->second_last_name) }}
                                    @endempty
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if (isset($ticket->formality->address))
                        <section>
                            <div class="form-row" style="margin-top: 30px; margin-bottom: 20px">
                                <span style="font-size: 20px;"><i class="fas fa-file-invoice"></i>
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
                                    <label for="inputZip">Escalera: </label>
                                    {{$ticket->formality->address->block_staircase}}
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
                    <div class="row">
                        <div class="form-row" style="margin-top: 20px; margin-bottom: 20px">
                            <span style="font-size: 20px;"><i class="fas fa-file-invoice"></i>
                                Datos del ticket
                            </span>
                        </div>
                        <div class="col-xl-4">
                            <ul class="list-unstyled">
                                <li class="text"><span class="fw-bold">Fecha emisión ticket:</span>
                                    @empty(!$ticket->created_at)
                                        {{ $ticket->created_at }}
                                    @endempty
                                </li>
                                <li class="text"><span class="fw-bold">Usuario asignado: </span>
                                    @empty(!$ticket->assigned)
                                        {{ ucfirst($ticket->assigned->name . ' ' . $ticket->assigned->first_last_name . ' ' . $ticket->assigned->second_last_name) }}
                                    @endempty
                                </li>
                                <li class="text"><span class="fw-bold">Descripción: </span>
                                    @empty(!$ticket->ticket_description)
                                        {{ ucfirst($ticket->ticket_description) }}
                                    @endempty
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <ul class="list-unstyled">
                                <li class="text"><span class="fw-bold">Título ticket: </span>
                                    @empty(!$ticket->ticket_title)
                                        {{ ucfirst($ticket->ticket_title) }}
                                    @endempty
                                </li>
                                <li class="text"><span class="fw-bold">Tipo ticket: </span>
                                    @empty(!$ticket->type)
                                        {{ ucfirst($ticket->type->name) }}
                                    @endempty
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <ul class="list-unstyled">
                                <li class="text">
                                    @empty(!$ticket->status)
                                        <x-badge.status :status="$ticket->status" />
                                    @endempty
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @livewire('ticket.edit-ticket-form', ['ticket' => $ticket])

            </div>

        </div>
    </div>


</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script src="/vendor/custom/badge.code.js"></script>
@stop