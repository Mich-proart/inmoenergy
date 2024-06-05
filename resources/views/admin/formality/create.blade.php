@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Nuevo Tramite</h1>
@stop

@section('content')
<div>

    <div class="card">
        <div class="card-body">
            {{html()->form('POST', route('api.formality.store'))->class('form-horizontal needs-validation')->open()}}
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="">Que quieres realizar?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        @if (isset($formalitytypes))
                            @foreach ($formalitytypes as $formalitytype)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="formalityTypeId"
                                        value="{{ $formalitytype->id }}">
                                    <label class="form-check-label" for="inlineCheckbox1">{{ $formalitytype->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="">Que suministro quieres tramitar (seleciona uno o varios)</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        @if (isset($services))
                            @foreach ($services as $service)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="serviceIds[]"
                                        value="{{ $service->id }}">
                                    <label class="form-check-label" for="inlineCheckbox1">{{ $service->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">

                <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                    Datos del Cliente
                </span>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputState">Tipo Cliente: </label>
                    <select class="form-control @error('clientTypeId') is-invalid @enderror" name="clientTypeId"
                        required>
                        <option value="">-- selecione --</option>
                        @if (isset($clientTypes))
                            @foreach ($clientTypes as $clientType)
                                <option value="{{ $clientType->id }}">{{ $clientType->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('clientTypeId')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Titulo: </label>
                    <select class="form-control @error('userTitleId') is-invalid @enderror" name="userTitleId" required>
                        <option value="">-- selecione --</option>
                        @if (isset($userTitles))
                            @foreach ($userTitles as $userTitle)
                                <option value="{{ $userTitle->id }}">{{ $userTitle->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('userTitleId')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputCity">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputCity"
                        name="name" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Apellido 1: </label>
                    <input type="text" class="form-control @error('firstLastName') is-invalid @enderror" id="inputCity"
                        name="firstLastName" required>
                    @error('firstLastName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputZip">Apellido 2: </label>
                    <input type="text" class="form-control" id="inputZip" name="secondLastName">
                    @error('firstLastName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputZip">Email: </label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="inputZip"
                        name="email" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputState">Tipo Document: </label>
                    <select class="form-control @error('documentTypeId') is-invalid @enderror" name="documentTypeId"
                        required>
                        <option value="">-- selecione --</option>
                        @if (isset($documentTypes))
                            @foreach ($documentTypes as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('documentTypeId')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Numero Documento: </label>
                    <input type="text" class="form-control" id="inputZip" name="documentNumber" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputAddress">telf: </label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="" name="phone">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputAddress">Tipo de vivienda: </label>
                    <select class="form-control @error('housingTypeId') is-invalid @enderror" name="housingTypeId"
                        required>
                        <option value="">-- selecione --</option>
                        @if (isset($housingTypes))
                            @foreach ($housingTypes as $housingType)
                                <option value="{{ $housingType->id }}">{{ $housingType->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('housingTypeId')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>
            <div class=" form-group">
                <label for="inputAddress2">Cuenta Bancaria: </label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="" name="IBAN">
            </div>
            <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">

                <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                    Dirección de suministro
                </span>
            </div>
            <div class="form-group">
                <livewire:address-elements />
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Observaciones</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Tramitar</button>
            {{html()->form()->close()}}


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
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop