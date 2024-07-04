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
                        <label for="inputState">Tipo Cliente: </label> {{ucfirst($formality->clientType)}}
                    </div>
                    <div class="form-group col-md-1">
                        <label for="inputState">Título: </label> {{ucfirst($formality->userTitle)}}
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputCity">Nombre</label> {{ucfirst($formality->name)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Primer apellido: </label> {{ucfirst($formality->firstLastName)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Segundo apellido: </label> {{ucfirst($formality->secondLastName)}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Tipo document: </label> {{ucfirst($formality->document_type)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Número documento: </label> {{$formality->documentNumber}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Teléfono: </label> {{$formality->phone}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Email: </label> {{$formality->email}}
                    </div>
                </div>

                <div class=" form-group">
                    <label for="inputAddress2">Cuenta Bancaria: </label> {{$formality->IBAN}}
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
                        <label for="inputZip">Tipo de calle: </label> {{ucfirst($formality->streetType)}}
                    </div>
                    <!-- street name -->
                    <div class="col-md-2">
                        <label for="inputZip">Nombre calle: </label> {{ucfirst($formality->streetName)}}
                    </div>
                    <!-- street number -->
                    <div class="col-md-1">
                        <label for="inputZip">N°: </label> {{$formality->streetNumber}}
                    </div>
                    <!-- block -->
                    <div class="col-md-1">
                        <label for="inputZip">Bloque: </label> {{$formality->block}}
                    </div>
                    <!-- staircase -->
                    <div class="col-md-1">
                        <label for="inputZip">Escalera: </label> {{$formality->blockstaircase}}
                    </div>
                    <!-- floor -->
                    <div class="col-md-1">
                        <label for="inputZip">Piso: </label> {{$formality->floor}}
                    </div>
                    <!-- door -->
                    <div class="col-md-1">
                        <label for="inputZip">Puerta: </label> {{$formality->door}}
                    </div>
                    <!-- housing -->
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Tipo de vivienda: </label> {{ucfirst($formality->housingType)}}
                    </div>
                </div>

                <div class="row">
                    <!-- province -->
                    <div class="col-md-3">
                        <label for="inputState">Provincia: </label> {{ucfirst($formality->province)}}
                    </div>
                    <!-- location -->
                    <div class="col-md-3">
                        <label for="inputState">Población: </label> {{ucfirst($formality->location)}}
                    </div>
                    <!-- zip code -->
                    <div class="col-md-2">
                        <label for="inputZip">Código postal: </label> {{$formality->zipCode}}
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
                            <label for="inputZip">Tipo de calle: </label> {{ucfirst($formality->client_streetType)}}
                        </div>
                        <!-- client street name -->
                        <div class="col-md-2">
                            <label for="inputZip">Nombre calle: </label> {{ucfirst($formality->client_streetName)}}
                        </div>

                        <!-- client street number -->
                        <div class="col-md-1">
                            <label for="inputZip">N°: </label> {{$formality->client_streetNumber}}
                        </div>
                        <!-- client block -->
                        <div class="col-md-1">
                            <label for="inputZip">Bloque: </label> {{$formality->client_block}}
                        </div>
                        <!-- client block staircase -->
                        <div class="col-md-1">
                            <label for="inputZip">Escalera: </label> {{$formality->client_blockstaircase}}
                        </div>
                        <!-- client floor -->
                        <div class="col-md-1">
                            <label for="inputZip">Piso: </label> {{$formality->client_floor}}
                        </div>
                        <!-- client door -->
                        <div class="col-md-1">
                            <label for="inputZip">Puerta: </label> {{$formality->door}}
                        </div>
                        <!-- client housing type -->
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Tipo de vivienda: </label>
                            {{ucfirst($formality->client_housingType)}}
                        </div>
                    </div>
                    <div class="row">
                        <!-- client province -->
                        <div class="col-md-3">
                            <label for="inputState">Provincia: </label> {{ucfirst($formality->client_province)}}
                        </div>

                        <!-- client location -->
                        <div class="col-md-3">
                            <label for="inputState">Población: </label> {{ucfirst($formality->client_location)}}
                        </div>
                        <!-- client zip code -->
                        <div class="col-md-2">
                            <label for="inputZip">Código postal: </label> {{$formality->client_zipCode}}
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
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones del tramitador</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"
                        @readonly(true)>{{$formality->issuer_observation}}</textarea>
                </div>

            </div>
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