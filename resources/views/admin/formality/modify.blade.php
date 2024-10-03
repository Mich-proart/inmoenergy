@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Trámite</h1>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
<div>

    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3">
            <div class="col-12 ">
                <h4>
                    @livewire('ticket.get-ticket-modal', ['formality' => $formality, 'to' => 'admin.ticket.modify', 'from' => 'admin.dashboard', 'checkStatus' => true])
                </h4>
            </div>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Cliente emisor trámite: </label> @if (isset($formality->issuer))
                                {{$formality->issuer->name . ' ' . $formality->issuer->first_last_name . ' ' . $formality->issuer->second_last_name}}
                            @endif
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Fecha de entrada:</label> {{$formality->created_at}}
                        </div>
                        <div id="status" class="col-sm-4 invoice-col">
                            <x-badge.status :status="$formality->status" />
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Usuario asignado: </label> @if (isset($formality->assigned))
                                {{$formality->assigned->name . ' ' . $formality->assigned->first_last_name . ' ' . $formality->assigned->second_last_name}}
                            @endif
                        </div>
                        @if (isset($from) && ($from == 'total' || $from == 'totalclosed'))
                            <div class="col-sm-4 invoice-col">
                                <label for="">Fecha de asignación:</label> @if (isset($formality->assignment_date))
                                    {{$formality->assignment_date}}
                                @endif
                            </div>
                        @endif

                        <div class="col-sm-4 invoice-col">
                            <label for="">Tramite crítico:</label>
                            @if ($formality->isCritical != "0")
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red"
                                    class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                </svg>
                            @endif

                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Tipo de trámite: </label> {{ucfirst($formality->type->name)}}
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Compañía suministro: </label>
                            @if (isset($formality->product) && isset($formality->product->company))
                                {{ucfirst($formality->product->company->name)}}
                            @endif
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Suministro tramitado: </label> {{ucfirst($formality->service->name)}}
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Producto Compañía:</label>
                            @if (isset($formality->product))
                                {{ucfirst($formality->product->name)}}
                            @endif
                        </div>
                        @if (isset($from) && $from == 'totalclosed')
                            <div class="col-sm-4 invoice-col">
                                <label for="">Fecha de finalización: </label> {{$formality->completion_date}}
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section>
                <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                    <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                        Datos del Cliente
                    </span>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputState">Tipo Cliente: </label> @if (isset($client->clientType))
                            {{ucfirst($client->clientType->name)}}
                        @endif
                    </div>
                    <div class="form-group col-md-1">
                        <label for="inputState">Título: </label> @if (isset($client->title))
                            {{ucfirst($client->title->name)}}
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputCity">Nombre</label> {{ucfirst($client->name)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Primer apellido: </label> {{ucfirst($client->first_last_name)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Segundo apellido: </label> {{ucfirst($client->second_last_name)}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Tipo documento: </label> @if (isset($client->documentType))
                            {{ucfirst($client->documentType->name)}}
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Número documento: </label> {{$client->document_number}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Teléfono: </label>
                        @isset($client->country)
                            +{{$client->country->phone_code}}
                        @endisset
                        {{$client->phone}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Email: </label> {{$client->email}}
                    </div>
                </div>

                <div class=" form-group">
                    <label for="inputAddress2">Cuenta Bancaria: </label> {{$client->IBAN}}
                </div>
            </section>
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
                        <label for="inputZip">Tipo de calle: </label> @if (isset($address->streetType))
                            {{ucfirst($address->streetType->name)}}
                        @endif
                    </div>
                    <!-- street name -->
                    <div class="col-md-2">
                        <label for="inputZip">Nombre calle: </label> @if (isset($address->street_name))
                            {{ucfirst($address->street_name)}}
                        @endif
                    </div>
                    <!-- street number -->
                    <div class="col-md-1">
                        <label for="inputZip">N°: </label> {{$address->street_number}}
                    </div>
                    <!-- block -->
                    <div class="col-md-1">
                        <label for="inputZip">Bloque: </label> {{$address->block}}
                    </div>
                    <!-- staircase -->
                    <div class="col-md-1">
                        <label for="inputZip">Escalera: </label> {{$address->block_staircase}}
                    </div>
                    <!-- floor -->
                    <div class="col-md-1">
                        <label for="inputZip">Piso: </label> {{$address->floor}}
                    </div>
                    <!-- door -->
                    <div class="col-md-1">
                        <label for="inputZip">Puerta: </label> {{$address->door}}
                    </div>
                    <!-- housing -->
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Tipo de vivienda: </label> @if (isset($address->housingType))
                            {{ucfirst($address->housingType->name)}}
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- province -->
                    <div class="col-md-3">
                        <label for="inputState">Provincia: </label> @if (isset($address->location->province))
                            @if ($address->location->province->region->name === $address->location->province->name)
                                {{ucfirst($address->location->province->name)}}
                            @else
                                {{ $address->location->province->region->name }}, {{ $address->location->province->name }}
                            @endif
                        @endif
                    </div>
                    <!-- location -->
                    <div class="col-md-3">
                        <label for="inputState">Población: </label> @if (isset($address->location))
                            {{ucfirst($address->location->name)}}
                        @endif
                    </div>
                    <!-- zip code -->
                    <div class="col-md-2">
                        <label for="inputZip">Código postal: </label> {{$address->zip_code}}
                    </div>
                </div>
            </section>
            <section x-data="{ buttonDisabled: false }">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 25px">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    value="{{$formality->isSameCorrespondenceAddress}}" id="is_same_address"
                                    name="is_same_address" x-on:click="buttonDisabled = !buttonDisabled"
                                    @checked(old('is_same_address', $formality->isSameCorrespondenceAddress))
                                    @disabled(true)>
                                <label class="form-check-label" for="invalidCheck2">
                                    La dirección de correspondencia es la misma que la dirección de suministro.
                                </label>

                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Dirección de correspondencia
                        </span>
                    </div>
                    <div class="row">
                        <!-- client street type -->
                        <div class="col-md-2">
                            <label for="inputZip">Tipo de calle: </label>
                            @if (isset($CorrespondenceAddress) && isset($CorrespondenceAddress->streetType))
                                @if (isset($CorrespondenceAddress->streetType))
                                    {{ucfirst($CorrespondenceAddress->streetType->name)}}
                                @endif

                            @endif
                        </div>
                        <!-- client street name -->
                        <div class="col-md-2">
                            <label for="inputZip">Nombre calle: </label> @if (isset($CorrespondenceAddress))
                                {{ucfirst($CorrespondenceAddress->street_name)}}
                            @endif
                        </div>

                        <!-- client street number -->
                        <div class="col-md-1">
                            <label for="inputZip">N°: </label> @if (isset($CorrespondenceAddress))
                                {{$CorrespondenceAddress->street_number}}
                            @endif
                        </div>
                        <!-- client block -->
                        <div class="col-md-1">
                            <label for="inputZip">Bloque: </label> @if (isset($CorrespondenceAddress))
                                {{$CorrespondenceAddress->block}}
                            @endif
                        </div>
                        <!-- client block staircase -->
                        <div class="col-md-1">
                            <label for="inputZip">Escalera: </label> @if (isset($CorrespondenceAddress))
                                {{$CorrespondenceAddress->block_staircase}}
                            @endif
                        </div>
                        <!-- client floor -->
                        <div class="col-md-1">
                            <label for="inputZip">Piso: </label> @if (isset($CorrespondenceAddress))
                                {{$CorrespondenceAddress->floor}}
                            @endif
                        </div>
                        <!-- client door -->
                        <div class="col-md-1">
                            <label for="inputZip">Puerta: </label> @if (isset($CorrespondenceAddress))
                                {{$CorrespondenceAddress->door}}
                            @endif
                        </div>
                        <!-- client housing type -->
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Tipo de vivienda: </label>
                            @if (isset($CorrespondenceAddress) && isset($CorrespondenceAddress->housingType))
                                {{ucfirst($CorrespondenceAddress->housingType->name)}}
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <!-- client province -->
                        <div class="col-md-3">
                            <label for="inputState">Provincia: </label>
                            @if (isset($CorrespondenceAddress) && isset($CorrespondenceAddress->location) && isset($CorrespondenceAddress->location->province))
                                @if ($CorrespondenceAddress->location->province->region->name === $CorrespondenceAddress->location->province->name)
                                    {{ucfirst($CorrespondenceAddress->location->province->name)}}
                                @else
                                    {{ $CorrespondenceAddress->location->province->region->name }},
                                    {{ $CorrespondenceAddress->location->province->name }}
                                @endif
                            @endif
                        </div>

                        <!-- client location -->
                        <div class="col-md-3">
                            <label for="inputState">Población: </label>
                            @if (isset($CorrespondenceAddress) && isset($CorrespondenceAddress->location))
                                {{ucfirst($CorrespondenceAddress->location->name)}}
                            @endif
                        </div>
                        <!-- client zip code -->
                        <div class="col-md-2">
                            <label for="inputZip">Código postal: </label> @if (isset($CorrespondenceAddress))
                                {{$CorrespondenceAddress->zip_code}}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            @if (isset($from) && $from == 'totalclosed')
                <section>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Datos de trámite
                        </span>
                    </div>
                    <div class="form-row">
                        @if ($formality->service->name !== 'agua')
                            <div class="form-group col-md-3">
                                <label for="">Tarifa acceso: </label> @if (isset($formality->accessRate))
                                    {{$formality->accessRate->name}}
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">CUPS: </label> @if (isset($formality->CUPS))
                                    {{$formality->CUPS}}
                                @endif
                            </div>
                        @endif
                        <div class="form-group col-md-4">
                            <label for="">Compañía suministro anterior: </label> @if (isset($formality->previousCompany))
                                {{' ' . ucfirst($formality->previousCompany->name)}}
                            @endif
                        </div>
                    </div>
                    @if ($formality->service->name !== 'agua')

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">Potencia: </label> @if (isset($formality->potency))
                                    <span>kW </span>{{$formality->potency_Spanish()}}
                                @endif
                            </div>

                        </div>
                    @endif
                </section>
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones del tramitador</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="issuer_observation"
                            @readonly(true)>{{$formality->issuer_observation}}</textarea>
                    </div>

                </div>
            @endif
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones del trámite</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"
                        @readonly(true)>{{$formality->observation}}</textarea>
                </div>

            </div>
            @if (isset($formality) && isset($from) && $from == 'total')
                @livewire('formality.modify-formality-form', ['formality' => $formality, 'prevStatus' => $prevStatus, 'from' => $from])
            @elseif (isset($formality) && isset($from) && $from == 'totalclosed')
                @livewire('formality.modify-total-closed', ['formality' => $formality])
            @else
                @if (isset($formality))
                    @livewire('formality.modify-formality-form', ['formality' => $formality, 'prevStatus' => $prevStatus, 'from' => null])
                @endif
            @endif

        </div>
    </div>

</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/custom/badge.code.js"></script>
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script>
    $(document).ready(function () {
        /*
        function statuscode(code) {
            return statusColor(code);
        }
        $('#status').html(
            `<label for="">Estado:</label> ${statuscode("{{-- {{$formality->status->name}} --}}")
    }`
        );
        */
    });
</script>
@stop