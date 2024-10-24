<div>
    <div class="">
        <div class="">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Usuario asignado: </label> @if (isset($formality->assigned))
                                {{$formality->assigned->name}} {{ " " . $formality->assigned->last_name}}
                                {{ " " . $formality->assigned->second_last_name}}
                            @endif
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Fecha de entrada:</label> {{$formality->created_at}}
                        </div>
                        @if ($from == 'closed')
                            <div class="col-sm-4 invoice-col">
                                <label for="">Fecha de finalización: </label> {{$formality->completion_date}}
                            </div>
                        @else
                            <div id="status" class="col-sm-4 invoice-col">
                                <x-badge.status :status="$formality->status" />
                            </div>
                        @endif
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Compañía suministro: </label>
                            @if (isset($formality->product) && isset($formality->product->company))
                                {{ucfirst($formality->product->company->name)}}
                            @endif
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <label for="">Producto Compañía:</label>
                            @if (isset($formality->product))
                                {{ucfirst($formality->product->name)}}
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
                        @if ($from == 'closed')
                            <div id="status" class="col-sm-4 invoice-col">
                                <x-badge.status :status="$formality->status" />
                            </div>
                        @endif
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Suministro tramitado: </label> {{ucfirst($formality->service->name)}}
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
                    <div class="form-group col-md-3">
                        <label for="inputState">Tipo Cliente: </label> @if (isset($formality->client->clientType))
                            {{ucfirst($formality->client->clientType->name)}}
                        @endif
                    </div>
                    <div class="form-group col-md-1">
                        <label for="inputState">Título: </label> @if (isset($formality->client->title))
                            {{ucfirst($formality->client->title->name)}}
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputCity">Nombre</label> {{ucfirst($formality->client->name)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Primer apellido: </label>
                        {{ucfirst($formality->client->first_last_name)}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Segundo apellido: </label>
                        {{ucfirst($formality->client->second_last_name)}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputState">Tipo documento: </label> @if (isset($formality->client->documentType))
                            {{ucfirst($formality->client->documentType->name)}}
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Número documento: </label> {{$formality->client->document_number}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Teléfono: </label>
                        @isset($formality->client->country)
                            +{{$formality->client->country->phone_code}}
                        @endisset
                        {{$formality->client->phone}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Email: </label> {{$formality->client->email}}
                    </div>
                </div>

                <div class=" form-group">
                    <label for="inputAddress2">Cuenta Bancaria: </label> {{$formality->client->IBAN}}
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
                        <label for="inputZip">Tipo de calle: </label> @if (isset($formality->address->streetType))
                            {{ucfirst($formality->address->streetType->name)}}
                        @endif
                    </div>
                    <!-- street name -->
                    <div class="col-md-3">
                        <label for="inputZip">Nombre calle: </label> @if (isset($formality->address->street_name))
                            {{ucfirst($formality->address->street_name)}}
                        @endif
                    </div>
                    <!-- street number -->
                    <div class="col-md-1">
                        <label for="inputZip">N°: </label> {{$formality->address->street_number}}
                    </div>
                    <!-- block -->
                    <div class="col-md-1">
                        <label for="inputZip">Bloque: </label> {{$formality->address->block}}
                    </div>
                    <!-- staircase -->
                    <div class="col-md-1">
                        <label for="inputZip">Escalera: </label> {{$formality->address->block_staircase}}
                    </div>
                    <!-- floor -->
                    <div class="col-md-1">
                        <label for="inputZip">Piso: </label> {{$formality->address->floor}}
                    </div>
                    <!-- door -->
                    <div class="col-md-1">
                        <label for="inputZip">Puerta: </label> {{$formality->address->door}}
                    </div>
                    <!-- housing -->
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Tipo de vivienda: </label>
                        @if (isset($formality->address->housingType))
                            {{ucfirst($formality->address->housingType->name)}}
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- province -->
                    <div class="col-md-3">
                        <label for="inputState">Provincia: </label> @if (isset($formality->address->location->province))
                            @if ($formality->address->location->province->region->name === $formality->address->location->province->name)
                                {{ucfirst($formality->address->location->province->name)}}
                            @else
                                {{ $formality->address->location->province->region->name }},
                                {{ $formality->address->location->province->name }}
                            @endif
                        @endif
                    </div>
                    <!-- location -->
                    <div class="col-md-3">
                        <label for="inputState">Población: </label> @if (isset($formality->address->location))
                            {{ucfirst($formality->address->location->name)}}
                        @endif
                    </div>
                    <!-- zip code -->
                    <div class="col-md-2">
                        <label for="inputZip">Código postal: </label> {{$formality->address->zip_code}}
                    </div>
                </div>
            </section>
            <section x-data="{ buttonDisabled: false }">
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
                            @if (isset($formality->CorrespondenceAddress) && isset($formality->CorrespondenceAddress->streetType))
                                @if (isset($formality->CorrespondenceAddress->streetType))
                                    {{ucfirst($formality->CorrespondenceAddress->streetType->name)}}
                                @endif

                            @endif
                        </div>
                        <!-- client street name -->
                        <div class="col-md-3">
                            <label for="inputZip">Nombre calle: </label> @if (isset($formality->CorrespondenceAddress))
                                {{ucfirst($formality->CorrespondenceAddress->street_name)}}
                            @endif
                        </div>

                        <!-- client street number -->
                        <div class="col-md-1">
                            <label for="inputZip">N°: </label> @if (isset($formality->CorrespondenceAddress))
                                {{$formality->CorrespondenceAddress->street_number}}
                            @endif
                        </div>
                        <!-- client block -->
                        <div class="col-md-1">
                            <label for="inputZip">Bloque: </label> @if (isset($formality->CorrespondenceAddress))
                                {{$formality->CorrespondenceAddress->block}}
                            @endif
                        </div>
                        <!-- client block staircase -->
                        <div class="col-md-1">
                            <label for="inputZip">Escalera: </label> @if (isset($formality->CorrespondenceAddress))
                                {{$formality->CorrespondenceAddress->block_staircase}}
                            @endif
                        </div>
                        <!-- client floor -->
                        <div class="col-md-1">
                            <label for="inputZip">Piso: </label> @if (isset($formality->CorrespondenceAddress))
                                {{$formality->CorrespondenceAddress->floor}}
                            @endif
                        </div>
                        <!-- client door -->
                        <div class="col-md-1">
                            <label for="inputZip">Puerta: </label> @if (isset($formality->CorrespondenceAddress))
                                {{$formality->CorrespondenceAddress->door}}
                            @endif
                        </div>
                        <!-- client housing type -->
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Tipo de vivienda: </label>
                            @if (isset($formality->CorrespondenceAddress) && isset($formality->CorrespondenceAddress->housingType))
                                {{ucfirst($formality->CorrespondenceAddress->housingType->name)}}
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <!-- client province -->
                        <div class="col-md-3">
                            <label for="inputState">Provincia: </label>
                            @if (isset($formality->CorrespondenceAddress) && isset($formality->CorrespondenceAddress->location) && isset($formality->CorrespondenceAddress->location->province))
                                @if ($formality->CorrespondenceAddress->location->province->region->name === $formality->CorrespondenceAddress->location->province->name)
                                    {{ucfirst($formality->CorrespondenceAddress->location->province->name)}}
                                @else
                                    {{ $formality->CorrespondenceAddress->location->province->region->name }},
                                    {{ $formality->CorrespondenceAddress->location->province->name }}
                                @endif
                            @endif
                        </div>

                        <!-- client location -->
                        <div class="col-md-3">
                            <label for="inputState">Población: </label>
                            @if (isset($formality->CorrespondenceAddress) && isset($formality->CorrespondenceAddress->location))
                                {{ucfirst($formality->CorrespondenceAddress->location->name)}}
                            @endif
                        </div>
                        <!-- client zip code -->
                        <div class="col-md-2">
                            <label for="inputZip">Código postal: </label> @if (isset($formality->CorrespondenceAddress))
                                {{$formality->CorrespondenceAddress->zip_code}}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            @if ($from == 'closed')
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones del trámite</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"
                            @readonly(true)>{{$formality->observation}}</textarea>
                    </div>

                </div>
            @endif
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones del asesor</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observation"
                        @readonly(true)>{{$formality->assigned_observation}}</textarea>
                </div>

            </div>
        </div>
    </div>
</div>