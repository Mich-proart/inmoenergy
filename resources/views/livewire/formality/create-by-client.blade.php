<div>

    <div class="col-12">
        <h5>Para un cliente nuevo</h5>
    </div>
    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3 mb-4">
            <div class="col-12 ">
                <h4>
                    <small class="float-left">
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('move-confirmation')">
                            Iniciar un nuevo trámite
                        </button>
                    </small>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-12">
        <h5>Para un cliente existente</h5>
    </div>
    <div class="card card-primary card-outline" style="height: 700px;">
        <div class="mt-3 mr-3 ms-5">
            <div class="col-12">
                <h4 class=" card-title fw-bold">Buscar el cliente en el sistema</h4>
            </div>
        </div>
        <div class="card-body">
            <div wire:ignore.self class="container" style="margin-left: 0px; margin-right: 0px">
                <div class="row" style="margin-bottom: 5px">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-end">
                            <div>Nombre completo / razon social</div>
                        </div>
                        <div class="col-5">
                            <div class="form-outline" data-mdb-input-init>
                                <input wire:model.live="search_full_name" type="search" id="search_full_name"
                                    class="form-control" aria-label="Search" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-end">
                            <div class="">Numero documento</div>
                        </div>
                        <div class="col-3">
                            <input wire:model.live="search_document_number" type="search" id="search_document_number"
                                class="form-control" aria-label="Search" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-end">
                            <div>Tipo cliente</div>
                        </div>
                        <div class="col-3">
                            <div class="form-outline" data-mdb-input-init>
                                <select wire:model.live="search_client_type_id" class="form-control" name="clientTypeId"
                                    id="search_client_type_id">
                                    <option value="">-- selecione --</option>
                                    @if (isset($clientTypes))
                                        @foreach ($clientTypes as $clientType)
                                            <option value="{{ $clientType->id }}">{{ ucfirst($clientType->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 50px;">
                    <div class="col-12">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-left" style="width:16.66%;">
                                        Nombre
                                    </th>
                                    <th scope="col" class="text-left" style="width:16.66%;">
                                        N° Documento
                                    </th>
                                    <th scope="col" class="text-left" style="width:16.66%;">
                                        Tipo
                                    </th>
                                    <th scope="col" class="text-left" style="width:16.66%;">
                                        Fecha de entrada
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset ($clients)
                                    @foreach ($clients as $client)
                                        <tr wire:click="getClient({{ $client->id }})" class="table-light">
                                            <td style="width:16.66%">
                                                {{ ucfirst($client->name . ' ' . $client->first_last_name . ' ' . $client->second_last_name) }}
                                            </td>
                                            <td style="width:16.66%">{{ $client->document_number }}</td>
                                            <td style="width:16.66%">{{ $client->clientType->name }}</td>
                                            <td style="width:16.66%">{{ $client->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                        <div>
                            @if (count($clients) > 0)
                                {{ $clients->links('components.pagination') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" hidden
            id="openModal">
            Launch static backdrop modal
        </button>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo trámite</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit="save">
                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>
                        @endforeach

                        <div class="modal-body">
                            <section>
                                @if (isset($client) && !empty($client))
                                    <div class="form-group">
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                <label for="">Cliente: </label> @isset($client)
                                                    {{ ucfirst($client->name . ' ' . $client->first_last_name . ' ' . $client->second_last_name) }}
                                                @endisset
                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <label for="">Fecha de entrada:</label> @isset($client)
                                                    {{ $client->created_at }}
                                                @endisset
                                            </div>
                                            <div id="status" class="col-sm-4 invoice-col">

                                            </div>
                                        </div>
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                <label for=""> Telefono: </label>
                                                {{"+" . $client->country->phone_code}} {{$client->phone}}

                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <label for="">Email:</label>
                                                {{$client->email}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </section>
                            <section>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">¿Qué quieres realizar?</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            @if (isset($formalitytypes))
                                                @foreach ($formalitytypes as $formalitytype)
                                                    <div class="form-check form-check-inline">
                                                        <input wire:model="form.formalityTypeId" class="form-check-input"
                                                            type="radio" id="" name="formalityTypeId"
                                                            value="{{ $formalitytype->id }}" required>
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox1">{{ ucfirst($formalitytype->name) }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">¿Qué suministro quieres tramitar? (Selecciona uno o
                                                varios).</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            @if (isset($services))
                                                @foreach ($services as $service)
                                                    <div class="form-check form-check-inline">
                                                        <input wire:model="form.serviceIds" class="form-check-input"
                                                            type="checkbox" id="" name="serviceIds[]"
                                                            wire:click="addInput({{ $service->id }})"
                                                            value="{{ $service->id }}">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox1">{{ ucfirst($service->name) }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                                    <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                                        Dirección de suministro
                                    </span>
                                </div>

                                @if (isset($addressHandler) && !empty($addressHandler))
                                    <div class="row">
                                        @foreach ($addressHandler as $key => $option)
                                            <div class="col-3">
                                                <input wire:model.live="selected_handler" wire:click="switchAddressHandler"
                                                    type="radio" class="btn-check" id="btn-check-{{$key}}" autocomplete="off"
                                                    name="addressHandler" value="{{$option['handler']}}">
                                                <label class="btn btn-outline-primary"
                                                    for="btn-check-{{$key}}">{{$option['display']}}</label><br>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($selected_handler == 'getAddress')
                                    @if (isset($client) && !empty($client))
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-left">

                                                    </th>
                                                    <th scope="col" class="text-left">
                                                        Direrección
                                                    </th>
                                                    <th scope="col" class="text-left">
                                                        Provincia
                                                    </th>
                                                    <th scope="col" class="text-left">
                                                        Población
                                                    </th>
                                                    <th scope="col" class="text-left">
                                                        Código postal
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($client->addresses as $addressOption)
                                                    @if (!$addressOption->pivot->iscorrespondence)
                                                        <tr class="table-light">
                                                            <td>
                                                                <div class="container text-center">
                                                                    <div class="col-1">
                                                                        <div class="form-check form-check-inline">
                                                                            <input wire:model="selectedAddressId"
                                                                                class="form-check-input" type="radio" id=""
                                                                                name="selectedAddressId"
                                                                                value="{{ $addressOption->id }}" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $addressOption->street_type . ' ' . $addressOption->street_name . ' ' . $addressOption->street_number . ' ' . $addressOption->block . ' ' . $addressOption->block_staircase . ' ' . $addressOption->floor . ' ' . $addressOption->door }}
                                                            </td>
                                                            <td>{{ $addressOption->location ? $addressOption->location->name : '' }}
                                                            </td>
                                                            <td>{{ $addressOption->location->province ? $addressOption->location->province->name : '' }}
                                                            </td>
                                                            <td>{{ $addressOption->zip_code }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                @elseif($selected_handler == 'newAddress')
                                    <section>
                                        <!-- street group -->
                                        <div class="row">
                                            <!-- street type -->
                                            <div class="col-md-2">
                                                <label for="inputZip">Tipo de calle: </label>
                                                <select wire:model="form.streetTypeId"
                                                    class="form-control @error('form.streetTypeId') is-invalid @enderror"
                                                    name="streetTypeId" required>
                                                    <option value="">-- seleccione --</option>
                                                    @if (isset($streetTypes))
                                                        @foreach ($streetTypes as $streetType)
                                                            <option value="{{ $streetType->id }}">{{ ucfirst($streetType->name) }}
                                                            </option>
                                                        @endforeach

                                                    @endif
                                                </select>
                                                @error('form.streetTypeId')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- street name -->
                                            <div class="col-md-2">
                                                <label for="inputZip">Nombre calle: </label>
                                                <input wire:model="form.streetName" type="text"
                                                    class="form-control @error('form.streetName') is-invalid @enderror"
                                                    id="inputZip" name="streetName" required>
                                                @error('form.streetName')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- street number -->
                                            <div class="col-md-1">
                                                <label for="inputZip">N°: </label>
                                                <input wire:model="form.streetNumber" type="text"
                                                    class="form-control @error('form.streetNumber') is-invalid @enderror"
                                                    id="inputZip" name="streetNumber" required>
                                                @error('form.streetNumber')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- block -->
                                            <div class="col-md-1">
                                                <label for="inputZip">Bloque: </label>
                                                <input wire:model="form.block" type="text"
                                                    class="form-control @error('form.block') is-invalid @enderror"
                                                    id="inputZip" name="block">
                                                @error('form.block')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- staircase -->
                                            <div class="col-md-1">
                                                <label for="inputZip">Escalera: </label>
                                                <input wire:model="form.blockstaircase" type="text"
                                                    class="form-control @error('form.blockstaircase') is-invalid @enderror"
                                                    id="inputZip" name="blockstaircase">
                                                @error('form.blockstaircase')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- floor -->
                                            <div class="col-md-1">
                                                <label for="inputZip">Piso: </label>
                                                <input wire:model="form.floor" type="text"
                                                    class="form-control @error('form.floor') is-invalid @enderror"
                                                    id="inputZip" name="floor">
                                                @error('form.floor')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- door -->
                                            <div class="col-md-1">
                                                <label for="inputZip">Puerta: </label>
                                                <input wire:model="form.door" type="text"
                                                    class="form-control @error('form.door') is-invalid @enderror"
                                                    id="inputZip" name="door">
                                                @error('form.door')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- housing -->
                                            <div class="form-group col-md-3">
                                                <label for="inputAddress">Tipo de vivienda: </label>
                                                <select wire:model="form.housingTypeId"
                                                    class="form-control @error('form.housingTypeId') is-invalid @enderror"
                                                    name="housingTypeId" required>
                                                    <option value="">-- selecione --</option>
                                                    @if (isset($housingTypes))
                                                        @foreach ($housingTypes as $housingType)
                                                            <option value="{{ $housingType->id }}">{{ ucfirst($housingType->name) }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('form.housingTypeId')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- province -->
                                            <div class="col-md-3">
                                                <label for="inputState">Provincia: </label>
                                                <select wire:model.live="target_provinceId" class="form-control"
                                                    id="inputProvince">
                                                    <option value="">-- seleccione --</option>
                                                    @foreach ($this->provinces as $province)
                                                        @if ($province->region->name === $province->name)
                                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                        @else
                                                            <option value="{{ $province->id }}">{{ $province->region->name }},
                                                                {{ $province->name }}
                                                            </option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- location -->
                                            <div class="col-md-3">
                                                <label for="inputState">Población: </label>
                                                <select wire:model="form.locationId"
                                                    class="form-control @error('form.locationId') is-invalid @enderror"
                                                    id="inputLocation" name="locationId" required>
                                                    <option value="">-- seleccione --</option>
                                                    @foreach ($this->locations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('form.locationId')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- zip code -->
                                            <div class="col-md-2">
                                                <label for="inputZip">Código postal: </label>
                                                <input wire:model="form.zipCode" type="text"
                                                    class="form-control @error('form.zipCode') is-invalid @enderror"
                                                    id="inputZip" name="zipCode" required>
                                                @error('form.zipCode')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </section>
                                @endif

                            </section>
                            <section>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 25px">
                                            <div class="form-check">
                                                <input wire:model.live="is_same_address"
                                                    wire:click="changeCorrespondece" class="form-check-input"
                                                    type="checkbox" value="0" id="is_same_address">
                                                <label class="form-check-label" for="invalidCheck2">
                                                    La dirección de correspondencia es la misma que la dirección de
                                                    suministro.
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!$is_same_address)
                                    <section>
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
                                                    <select wire:model="form.client_streetTypeId"
                                                        class="form-control @error('form.client_streetTypeId') is-invalid @enderror"
                                                        name="client_streetTypeId" id="client_streetTypeId" required
                                                        x-bind:disabled="buttonDisabled">
                                                        <option value="">-- seleccione --</option>
                                                        @if (isset($streetTypes))
                                                            @foreach ($streetTypes as $streetType)
                                                                <option value="{{ $streetType->id }}">
                                                                    {{ ucfirst($streetType->name) }}
                                                                </option>
                                                            @endforeach

                                                        @endif
                                                    </select>
                                                    @error('form.client_streetTypeId')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client street name -->
                                                <div class="col-md-2">
                                                    <label for="inputZip">Nombre calle: </label>
                                                    <input wire:model="form.client_streetName" type="text"
                                                        class="form-control @error('form.client_streetName') is-invalid @enderror"
                                                        id="client_streetName" name="client_streetName" required
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_streetName')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <!-- client street number -->
                                                <div class="col-md-1">
                                                    <label for="inputZip">N°: </label>
                                                    <input wire:model="form.client_streetNumber" type="text"
                                                        class="form-control @error('form.client_streetNumber') is-invalid @enderror"
                                                        id="client_streetNumber" name="client_streetNumber" required
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_streetNumber')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client block -->
                                                <div class="col-md-1">
                                                    <label for="inputZip">Bloque: </label>
                                                    <input wire:model="form.client_block" type="text"
                                                        class="form-control @error('form.client_block') is-invalid @enderror"
                                                        id="client_block" name="client_block"
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_block')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client block staircase -->
                                                <div class="col-md-1">
                                                    <label for="inputZip">Escalera: </label>
                                                    <input wire:model="form.client_blockstaircase" type="text"
                                                        class="form-control @error('form.client_blockstaircase') is-invalid @enderror"
                                                        id="client_blockstaircase" name="client_blockstaircase"
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_blockstaircase')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client floor -->
                                                <div class="col-md-1">
                                                    <label for="inputZip">Piso: </label>
                                                    <input wire:model="form.client_floor" type="text"
                                                        class="form-control @error('form.client_floor') is-invalid @enderror"
                                                        id="client_floor" name="client_floor"
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_floor')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client door -->
                                                <div class="col-md-1">
                                                    <label for="inputZip">Puerta: </label>
                                                    <input wire:model="form.client_door" type="text"
                                                        class="form-control @error('form.client_door') is-invalid @enderror"
                                                        id="client_door" name="client_door"
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_door')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client housing type -->
                                                <div class="form-group col-md-3">
                                                    <label for="inputAddress">Tipo de vivienda: </label>
                                                    <select wire:model="form.client_housingTypeId"
                                                        class="form-control @error('form.client_housingTypeId') is-invalid @enderror"
                                                        name="client_housingTypeId" id="client_housingTypeId" required
                                                        x-bind:disabled="buttonDisabled">
                                                        <option value="">-- selecione --</option>
                                                        @if (isset($housingTypes))
                                                            @foreach ($housingTypes as $housingType)
                                                                <option value="{{ $housingType->id }}">
                                                                    {{ ucfirst($housingType->name) }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('form.client_housingTypeId')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- client province -->
                                                <div class="col-md-3">
                                                    <label for="inputState">Provincia: </label>
                                                    <select wire:model.live="target_clientProvinceId" class="form-control"
                                                        id="client_inputProvince" x-bind:disabled="buttonDisabled">
                                                        <option value="">-- seleccione --</option>
                                                        @foreach ($this->clientProvinces as $province)
                                                            @if ($province->region->name === $province->name)
                                                                <option value="{{ $province->id }}">{{ $province->name }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $province->id }}">
                                                                    {{ $province->region->name }},
                                                                    {{ $province->name }}
                                                                </option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- client location -->
                                                <div class="col-md-3">
                                                    <label for="inputState">Población: </label>
                                                    <select wire:model="form.client_locationId"
                                                        class="form-control @error('form.client_locationId') is-invalid @enderror"
                                                        id="client_locationId" name="client_locationId" required
                                                        x-bind:disabled="buttonDisabled">
                                                        <option value="">-- seleccione --</option>
                                                        @foreach ($this->clientLocations as $clientLocation)
                                                            <option value="{{ $clientLocation->id }}">
                                                                {{ $clientLocation->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('form.client_locationId')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- client zip code -->
                                                <div class="col-md-2">
                                                    <label for="inputZip">Código postal: </label>
                                                    <input wire:model="form.client_zipCode" type="text"
                                                        class="form-control @error('form.client_zipCode') is-invalid @enderror"
                                                        id="client_zipCode" name="client_zipCode" required
                                                        x-bind:disabled="buttonDisabled">
                                                    @error('form.client_zipCode')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                @endif
                            </section>
                            <div style="margin-top: 50px; margin-bottom: 25px">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Observaciones del trámite</label>
                                    <textarea wire:model="form.observation" class="form-control"
                                        id="exampleFormControlTextarea1" rows="3" name="observation"></textarea>
                                </div>

                            </div>
                            <div>
                                <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                                    <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                                        Documentos
                                    </span>
                                </div>
                                @foreach($inputs as $key => $input)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inputZip">{{ucfirst($input['name'])}}: </label>
                                            <input wire:model.defer="inputs.{{$key}}.file" type="file"
                                                class="form-control @error('inputs.' . $key . '.file') is-invalid @enderror"
                                                id="input_{{$key}}_file">
                                            @error('inputs.' . $key . '.file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div wire:loading wire:target="inputs.{{$key}}.file">Subiendo archivo...</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button wire:click="closeProccess" type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal" id="closeProccessBtn">Close</button>
                            <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                                Tramitar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    @script
    <script>

        $wire.on('checks', (e) => {
            console.log(e);
            Swal.fire({
                confirmButtonColor: '#004a99',
                icon: "error",
                title: e.title,
                text: e.error,
            });
        });

        $wire.on('created-confirmation', () => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Trámite creado exitosamente",
                showConfirmButton: false,
                timer: 1500
            });
            $('#closeProccessBtn').click();
        })

        $wire.on('start-confirmation', (e) => {
            Swal.fire({
                title: "¿Seguro que quieres dar de alta un nuevo trámite?",
                text: "Al aceptar iniciara el proceso para el cliente seleccionado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "si",
                cancelButtonText: "no"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#openModal').click();
                }
            });
        });

        $wire.on('move-confirmation', () => {
            Swal.fire({
                title: "¿Seguro que quieres iniciar un nuevo trámite?",
                text: "Al aceptar iniciara el proceso para un nuevo cliente.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "si",
                cancelButtonText: "no"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.formality.create.client') }}"
                }
            });
        });

        $wire.on('load', () => {
            // document.querySelector('.spinner-wrapper').style.display = 'block';
        })
    </script>
    @endscript

</div>