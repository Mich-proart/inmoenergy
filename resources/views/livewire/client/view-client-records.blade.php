<div>
    {{-- Client Search Section --}}
    <div class="card card-success card-outline">
        <div class="card-header">
            <h4 class="card-title fw-bold">Buscar el cliente en el sistema</h4>
        </div>
        <div class="card-body">
            <div class="container" style="margin-left: 0px; margin-right: 0px">
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <label>Nombre completo / razón social</label>
                    </div>
                    <div class="col-5">
                        <input wire:model.live="search_full_name" type="search" class="form-control" 
                               placeholder="Buscar por nombre..." />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <label>Número documento</label>
                    </div>
                    <div class="col-3">
                        <input wire:model.live="search_document_number" type="search" class="form-control" 
                               placeholder="Número de documento..." />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-3 d-flex justify-content-end align-items-center">
                        <label>Tipo cliente</label>
                    </div>
                    <div class="col-3">
                        <select wire:model.live="search_client_type_id" class="form-control">
                            <option value="">-- seleccione --</option>
                            @if (isset($clientTypes))
                                @foreach ($clientTypes as $clientType)
                                    <option value="{{ $clientType->id }}">{{ ucfirst($clientType->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                {{-- Search Results Table --}}
                @if(!empty($search_full_name) || !empty($search_document_number) || !empty($search_client_type_id))
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-12">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-left" style="width:25%;">Nombre</th>
                                        <th scope="col" class="text-left" style="width:20%;">N° Documento</th>
                                        <th scope="col" class="text-left" style="width:15%;">Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($clients) > 0)
                                        @foreach ($clients as $client)
                                            <tr wire:click="selectClient({{ $client->id }})" 
                                                class="table-light" style="cursor: pointer;">
                                                <td>{{ ucfirst($client->name . ' ' . $client->first_last_name . ' ' . $client->second_last_name) }}</td>
                                                <td>{{ $client->document_number }}</td>
                                                <td>{{ $client->clientType->name }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">No se encontraron clientes</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @if (count($clients) > 0)
                                {{ $clients->links('components.pagination') }}
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Client Data and Addresses Section --}}
    @if($selectedClient)
        <div class="row mt-4">
            {{-- Left Column: Client Data --}}
            <div class="col-md-7">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-user"></i> Datos del Cliente</h5>
                    </div>
                    <div class="card-body client-data-section">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Tipo Cliente:</label>
                                <input type="text" value="{{ $selectedClient->clientType ? ucfirst($selectedClient->clientType->name) : '' }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Título:</label>
                                <input type="text" value="{{ $selectedClient->title ? ucfirst($selectedClient->title->name) : '' }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Tipo documento:</label>
                                <input type="text" value="{{ $selectedClient->documentType ? ucfirst($selectedClient->documentType->name) : '' }}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Nombre:</label>
                                <input type="text" value="{{ $selectedClient->name }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Primer apellido:</label>
                                <input type="text" value="{{ $selectedClient->first_last_name }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Segundo apellido:</label>
                                <input type="text" value="{{ $selectedClient->second_last_name }}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Número documento:</label>
                                <input type="text" value="{{ $selectedClient->document_number }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>Email:</label>
                                <input type="email" value="{{ $selectedClient->email }}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Teléfono:</label>
                                <input type="text" value="{{ $selectedClient->phone }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>IBAN:</label>
                                <input type="text" value="{{ $selectedClient->IBAN }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Address List --}}
            <div class="col-md-5">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Dirección de suministro</h5>
                    </div>
                    <div class="card-body">
                        <div class="address-list">
                            @if($selectedClient->addresses->count() > 0)
                                @foreach($selectedClient->addresses as $address)
                                    <div wire:click="selectAddress({{ $address->id }})" 
                                         class="address-item @if($selectedAddress && $selectedAddress->id == $address->id) active @endif">
                                        <div><strong>Dirección:</strong> 
                                            {{ $address->streetType ? $address->streetType->name : '' }} 
                                            {{ $address->street_name }} 
                                            {{ $address->street_number }}
                                            @if($address->block) , Bloque {{ $address->block }} @endif
                                            @if($address->floor) , {{ $address->floor }}º @endif
                                            @if($address->door) {{ $address->door }} @endif
                                        </div>
                                        <div><strong>Provincia:</strong> {{ $address->location && $address->location->province ? $address->location->province->name : '' }}</div>
                                        <div><strong>Población:</strong> {{ $address->location ? $address->location->name : '' }}</div>
                                        <div><strong>Código postal:</strong> {{ $address->zip_code }}</div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">No hay direcciones registradas para este cliente.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Address Data Section (Read-Only) --}}
        @if($selectedAddress)
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-home"></i> Dirección de 
                                @php
                                    $pivot = $selectedClient->addresses->where('id', $selectedAddress->id)->first()->pivot ?? null;
                                @endphp
                                @if($pivot && $pivot->iscorrespondence)
                                    correspondencia
                                @else
                                    suministro
                                @endif
                            </h5>
                        </div>
                        <div class="card-body client-data-section">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label>Tipo de calle:</label>
                                    <input type="text" value="{{ $selectedAddress->streetType ? ucfirst($selectedAddress->streetType->name) : '' }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label>Nombre calle:</label>
                                    <input type="text" value="{{ $selectedAddress->street_name }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-1">
                                    <label>N°:</label>
                                    <input type="text" value="{{ $selectedAddress->street_number }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label>Bloque:</label>
                                    <input type="text" value="{{ $selectedAddress->block }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label>Escalera:</label>
                                    <input type="text" value="{{ $selectedAddress->block_staircase }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-1">
                                    <label>Piso:</label>
                                    <input type="text" value="{{ $selectedAddress->floor }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-1">
                                    <label>Puerta:</label>
                                    <input type="text" value="{{ $selectedAddress->door }}" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Provincia:</label>
                                    <input type="text" value="{{ $selectedAddress->location && $selectedAddress->location->province ? ($selectedAddress->location->province->region->name === $selectedAddress->location->province->name ? $selectedAddress->location->province->name : $selectedAddress->location->province->region->name . ', ' . $selectedAddress->location->province->name) : '' }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label>Población:</label>
                                    <input type="text" value="{{ $selectedAddress->location ? $selectedAddress->location->name : '' }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label>Código postal:</label>
                                    <input type="text" value="{{ $selectedAddress->zip_code }}" class="form-control" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label>Tipo de vivienda:</label>
                                    <input type="text" value="{{ $selectedAddress->housingType ? ucfirst($selectedAddress->housingType->name) : '' }}" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
