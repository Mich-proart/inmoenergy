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
                    <small class="float-right"><button class="btn btn-primary btn-sm">Nuevo ticket</button></small>
                </h4>
            </div>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Usuario asignado: </label> {{$formality->assigned}}
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Fecha:</label> {{$formality->created_at}}
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Estado:</label> <span
                                class="badge rounded-pill bg-info text-dark">{{$formality->status}} </span>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Compañía suministro: </label>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Producto Compañía:</label>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Tramite critico:</label>
                            <input type="checkbox" name="isCritical" id="" @checked(old('isCritical', $formality->isCritical)) onclick="return false;">
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Tipo de trámite: </label> {{ucfirst($formality->type)}}
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Suministro tramitado: </label> {{ucfirst($formality->service)}}
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
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputState">Tipo Cliente: </label>
                        <div>{{ucfirst($formality->clientType)}}</div>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="inputState">Título: </label>
                        <div>{{ucfirst($formality->userTitle)}}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputCity">Nombre</label>
                        <div>{{ucfirst($formality->name)}}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Primer apellido: </label>
                        <div>{{ucfirst($formality->firstLastName)}}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Segundo apellido: </label>
                        <div>{{ucfirst($formality->secondLastName)}}</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Tipo document: </label>
                        <div>{{ucfirst($formality->document_type)}}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Número documento: </label>
                        <div>{{$formality->documentNumber}}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Teléfono: </label>
                        <div>{{$formality->phone}}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Email: </label>
                        <div>{{$formality->email}}</div>
                    </div>
                </div>

                <div class=" form-group">
                    <label for="inputAddress2">Cuenta Bancaria: </label>
                    <div>{{$formality->IBAN}}</div>
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
                        <label for="inputZip">Tipo de calle: </label>
                        <div>{{ucfirst($formality->streetType)}}</div>
                    </div>
                    <!-- street name -->
                    <div class="col-md-2">
                        <label for="inputZip">Nombre calle: </label>
                        <div>{{ucfirst($formality->streetName)}}</div>
                    </div>
                    <!-- street number -->
                    <div class="col-md-1">
                        <label for="inputZip">N°: </label>
                        <div>{{$formality->streetNumber}}</div>
                    </div>
                    <!-- block -->
                    <div class="col-md-1">
                        <label for="inputZip">Bloque: </label>
                        <div>{{$formality->block}}</div>
                    </div>
                    <!-- staircase -->
                    <div class="col-md-1">
                        <label for="inputZip">Escalera: </label>
                        <div>{{$formality->blockstaircase}}</div>
                    </div>
                    <!-- floor -->
                    <div class="col-md-1">
                        <label for="inputZip">Piso: </label>
                        <div>{{$formality->floor}}</div>
                    </div>
                    <!-- door -->
                    <div class="col-md-1">
                        <label for="inputZip">Puerta: </label>
                        <div>{{$formality->door}}</div>
                    </div>
                    <!-- housing -->
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Tipo de vivienda: </label>
                        <div>{{ucfirst($formality->housingType)}}</div>
                    </div>
                </div>

                <div class="row">
                    <!-- province -->
                    <div class="col-md-3">
                        <label for="inputState">Provincia: </label>
                        <div>{{ucfirst($formality->province)}}</div>
                    </div>
                    <!-- location -->
                    <div class="col-md-3">
                        <label for="inputState">Población: </label>
                        <div>{{ucfirst($formality->location)}}</div>
                    </div>
                    <!-- zip code -->
                    <div class="col-md-2">
                        <label for="inputZip">Código postal: </label>
                        <div>{{$formality->zipCode}}</div>
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
                            <div>{{ucfirst($formality->client_streetType)}}</div>
                        </div>
                        <!-- client street name -->
                        <div class="col-md-2">
                            <label for="inputZip">Nombre calle: </label>
                            <div>{{ucfirst($formality->client_streetName)}}</div>
                        </div>

                        <!-- client street number -->
                        <div class="col-md-1">
                            <label for="inputZip">N°: </label>
                            <div>{{$formality->client_streetNumber}}</div>
                        </div>
                        <!-- client block -->
                        <div class="col-md-1">
                            <label for="inputZip">Bloque: </label>
                            <div>{{$formality->client_block}}</div>
                        </div>
                        <!-- client block staircase -->
                        <div class="col-md-1">
                            <label for="inputZip">Escalera: </label>
                            <div>{{$formality->client_blockstaircase}}</div>
                        </div>
                        <!-- client floor -->
                        <div class="col-md-1">
                            <label for="inputZip">Piso: </label>
                            <div>{{$formality->client_floor}}</div>
                        </div>
                        <!-- client door -->
                        <div class="col-md-1">
                            <label for="inputZip">Puerta: </label>
                            <div>{{$formality->door}}</div>
                        </div>
                        <!-- client housing type -->
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Tipo de vivienda: </label>
                            <div>{{ucfirst($formality->client_housingType)}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- client province -->
                        <div class="col-md-3">
                            <label for="inputState">Provincia: </label>
                            <div>{{ucfirst($formality->client_province)}}</div>
                        </div>

                        <!-- client location -->
                        <div class="col-md-3">
                            <label for="inputState">Población: </label>
                            <div>{{ucfirst($formality->client_location)}}</div>
                        </div>
                        <!-- client zip code -->
                        <div class="col-md-2">
                            <label for="inputZip">Código postal: </label>
                            <div>{{$formality->client_zipCode}}</div>
                        </div>
                    </div>
                </div>
            </section>
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"
                        @readonly(true)>{{$formality->observation}}</textarea>
                </div>

            </div>

            @if (isset($formality))
                @livewire('modify-formality', ['formality' => $formality, 'prevStatus' => $prevStatus])
            @endif

        </div>
    </div>

</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop