@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Nuevo Tramite</h1>
@stop

@section('content')
<div>

    <div class="card">
        <div class="card-body">
            {{html()->form('POST', route('admin.formality.store'))->class('form-horizontal')->open()}}
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
            <div class="form-row" style="margin-top: 50px;">
                <h4>Datos del Cliente</h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputState">Tipo Cliente: </label>
                    <x-dropdowm-form :options="$clientTypes" name="clientTypeId" />
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Titulo: </label>
                    <x-dropdowm-form :options="$userTitles" name="userTitleId" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputCity">Nombre</label>
                    <input type="text" class="form-control" id="inputCity" name="name">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Apellido 1: </label>
                    <input type="text" class="form-control" id="inputCity" name="firstLastName">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputZip">Apellido 2: </label>
                    <input type="text" class="form-control" id="inputZip" name="secondLastName">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputZip">Email: </label>
                    <input type="text" class="form-control" id="inputZip" name="email">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputState">Tipo Document: </label>
                    <!-- <x-dropdowm-form :options="$documentTypes" name="documentTypeId" /> -->
                    <select class="form-control" name="documentTypeId">
                        <option value="">-- selecione --</option>
                        @if (isset($documentTypes))
                            @foreach ($documentTypes as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Numero Documento: </label>
                    <input type="text" class="form-control" id="inputZip" name="documentNumber">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputAddress">telf: </label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="" name="phone">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputAddress">Tipo de vivienda: </label>
                    <x-dropdowm-form :options="$housingTypes" name="housingTypeId" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress2">Cuenta Bancaria: </label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="" name="IBAN">
            </div>
            <div class="form-row" style="margin-top: 50px;">
                <h4>Dirección de suministro</h4>
            </div>
            <div class="form-group">
                <livewire:address-elements />
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>

            @error('formalityTypeId')
                <div class="alert alert-danger">{{ $message }}</div>

            @enderror
            @error('issuierId')
                <div class="alert alert-danger">{{ $message }}</div>

            @enderror
            @error('observation')
                <div class="alert alert-danger">{{ $message }}</div>

            @enderror


            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('documentNumber')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('IBAN')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('clientTypeId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('userTitleId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('documentTypeId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('serviceIds')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('locationId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('streetTypeId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('streetName')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('streetNumber')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('zipCode')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('housingTypeId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('clientTypeId')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror



            <button type="submit" class="btn btn-primary">Enviar</button>
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