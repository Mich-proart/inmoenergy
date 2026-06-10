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
                                @if(!$editingClient)
                                    <input type="text" value="{{ $selectedClient->clientType ? ucfirst($selectedClient->clientType->name) : '' }}" class="form-control" disabled>
                                @else
                                    <select wire:model.live="clientForm.client_type_id" class="form-control">
                                        <option value="">-- seleccione --</option>
                                        @foreach($clientTypes as $type)
                                            <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('clientForm.client_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label>Título:</label>
                                @if(!$editingClient)
                                    <input type="text" value="{{ $selectedClient->title ? ucfirst($selectedClient->title->name) : '' }}" class="form-control" disabled>
                                @else
                                    <select wire:model="clientForm.user_title_id" class="form-control" @if($nameLabel === 'Razón social') disabled @endif>
                                        <option value="">-- seleccione --</option>
                                        @foreach($userTitles as $title)
                                            <option value="{{ $title->id }}">{{ ucfirst($title->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('clientForm.user_title_id') <span class="text-danger">{{ $message }}</span> @enderror
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label>Tipo documento:</label>
                                @if(!$editingClient)
                                    <input type="text" value="{{ $selectedClient->documentType ? ucfirst($selectedClient->documentType->name) : '' }}" class="form-control" disabled>
                                @else
                                    <select wire:model="clientForm.document_type_id" class="form-control" @if($nameLabel === 'Razón social') disabled @endif>
                                        <option value="">-- seleccione --</option>
                                        @foreach($documentTypes as $docType)
                                            <option value="{{ $docType->id }}">{{ ucfirst($docType->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('clientForm.document_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>{{ $nameLabel }}:</label>
                                <input type="text" wire:model="clientForm.name" class="form-control" 
                                       @if(!$editingClient) disabled @endif>
                                @error('clientForm.name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label>Primer apellido:</label>
                                <input type="text" wire:model="clientForm.first_last_name" class="form-control" 
                                       @if(!$editingClient || $nameLabel === 'Razón social') disabled @endif>
                                @error('clientForm.first_last_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label>Segundo apellido:</label>
                                <input type="text" wire:model="clientForm.second_last_name" class="form-control" 
                                       @if(!$editingClient || $nameLabel === 'Razón social') disabled @endif>
                                @error('clientForm.second_last_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Número documento:</label>
                                <input type="text" wire:model="clientForm.document_number" class="form-control" 
                                       @if(!$editingClient) disabled @endif>
                                @error('clientForm.document_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Email:</label>
                                <input type="email" wire:model="clientForm.email" class="form-control" 
                                       @if(!$editingClient) disabled @endif>
                                @error('clientForm.email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Teléfono:</label>
                                <input type="text" wire:model="clientForm.phone" class="form-control" 
                                       @if(!$editingClient) disabled @endif>
                                @error('clientForm.phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label>IBAN:</label>
                                <div class="form-check" style="margin-bottom: 10px;">
                                    <input wire:model.live="clientForm.is_foreign_account" class="form-check-input" type="checkbox"
                                        id="clientForm_is_foreign_account" @if(!$editingClient) disabled @endif>
                                    <label class="form-check-label" for="clientForm_is_foreign_account">
                                        Cuenta extranjera
                                    </label>
                                </div>
                                <input type="text" wire:model="clientForm.IBAN" class="form-control" 
                                       @if(!$editingClient) disabled @endif>
                                @error('clientForm.IBAN') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @if(!$editingClient)
                                    <button wire:click="enableClientEdit" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Editar datos cliente
                                    </button>
                                @else
                                    <button wire:click="saveClient" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar datos
                                    </button>
                                    <button wire:click="cancelClientEdit" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Address List --}}
            <div class="col-md-5">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Dirección de suministro / correspondencia</h5>
                    </div>
                    <div class="card-body">
                        <div class="address-list">
                            @if($selectedClient->addresses->count() > 0)
                                @foreach($selectedClient->addresses as $address)
                                    <div wire:click="selectAddress({{ $address->id }})" 
                                         class="address-item @if($selectedAddress && $selectedAddress->id == $address->id) active @endif">
                                        <div><strong>Dirección:</strong> 
                                            @if($address->pivot->iscorrespondence)
                                                <span class="badge badge-secondary float-right">Correspondencia</span>
                                            @else
                                                <span class="badge badge-secondary float-right">Suministro</span>
                                            @endif 
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

        {{-- Address Data Section --}}
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
                                    @if(!$editingAddress)
                                        <input type="text" value="{{ $selectedAddress->streetType ? ucfirst($selectedAddress->streetType->name) : '' }}" class="form-control" disabled>
                                    @else
                                        <select wire:model="addressForm.street_type_id" class="form-control">
                                            <option value="">-- seleccione --</option>
                                            @foreach($streetTypes as $type)
                                                <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('addressForm.street_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label>Nombre calle:</label>
                                    <input type="text" wire:model="addressForm.street_name" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.street_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-1">
                                    <label>N°:</label>
                                    <input type="text" wire:model="addressForm.street_number" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.street_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label>Bloque:</label>
                                    <input type="text" wire:model="addressForm.block" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.block') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label>Escalera:</label>
                                    <input type="text" wire:model="addressForm.block_staircase" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.block_staircase') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-1">
                                    <label>Piso:</label>
                                    <input type="text" wire:model="addressForm.floor" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.floor') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-1">
                                    <label>Puerta:</label>
                                    <input type="text" wire:model="addressForm.door" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.door') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Provincia:</label>
                                    @if(!$editingAddress)
                                        <input type="text" value="{{ $selectedAddress->location && $selectedAddress->location->province ? ($selectedAddress->location->province->region->name === $selectedAddress->location->province->name ? $selectedAddress->location->province->name : $selectedAddress->location->province->region->name . ', ' . $selectedAddress->location->province->name) : '' }}" class="form-control" disabled>
                                    @else
                                        <select wire:model.live="target_provinceId" class="form-control">
                                            <option value="">-- seleccione --</option>
                                            @foreach($this->provinces as $province)
                                                @if ($province->region->name === $province->name)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @else
                                                    <option value="{{ $province->id }}">{{ $province->region->name }}, {{ $province->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label>Población:</label>
                                    @if(!$editingAddress)
                                        <input type="text" value="{{ $selectedAddress->location ? $selectedAddress->location->name : '' }}" class="form-control" disabled>
                                    @else
                                        <select wire:model="addressForm.location_id" class="form-control">
                                            <option value="">-- seleccione --</option>
                                            @foreach($this->locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('addressForm.location_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label>Código postal:</label>
                                    <input type="text" wire:model="addressForm.zip_code" class="form-control" 
                                           @if(!$editingAddress) disabled @endif>
                                    @error('addressForm.zip_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>Tipo de vivienda:</label>
                                    @if(!$editingAddress)
                                        <input type="text" value="{{ $selectedAddress->housingType ? ucfirst($selectedAddress->housingType->name) : '' }}" class="form-control" disabled>
                                    @else
                                        <select wire:model="addressForm.housing_type_id" class="form-control">
                                            <option value="">-- seleccione --</option>
                                            @foreach($housingTypes as $type)
                                                <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('addressForm.housing_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    @if(!$editingAddress)
                                        <button wire:click="enableAddressEdit" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Editar datos
                                        </button>
                                    @else
                                        <button wire:click="saveAddress" class="btn btn-success">
                                            <i class="fas fa-save"></i> Guardar datos
                                        </button>
                                        <button wire:click="cancelAddressEdit" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Apartado Documentos Cliente -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-folder-open mr-1"></i>
                                Documentación del cliente
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tipología del documento</th>
                                            <th>Archivo actual</th>
                                            <th class="text-center" style="width: 150px;">Descargar</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($this->clientFileConfigs as $config)
                                            @php
                                                $clientFile = $selectedClient ? $selectedClient->files->firstWhere('config_id', $config->id) : null;
                                            @endphp
                                            <tr>
                                                <td class="align-middle"><strong>{{ ucfirst($config->name) }}</strong></td>
                                                <td class="align-middle">
                                                    @if($clientFile)
                                                        <span class="text-success"><i class="fas fa-check-circle mr-1"></i> {{ $clientFile->filename }}</span>
                                                    @else
                                                        <span class="text-muted"><i class="fas fa-exclamation-circle mr-1"></i> No subido</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if($clientFile)
                                                        @php
                                                            $filePath = storage_path('app/public/' . $clientFile->folder . '/' . $clientFile->filename);
                                                        @endphp
                                                        @if(file_exists($filePath))
                                                            <a href="{{ route('admin.documents.download', $clientFile->id) }}" >
                                                                <button class="btn btn-success btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                        fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                                            <path
                                                                                d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                                        </svg>
                                                                    Descargar</button>
                                                            </a>
                                                        @else
                                                            <span class="badge badge-danger">No disponible</span>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle" style="width: 400px;">
                                                    <div class="d-flex align-items-center">
                                                        <input type="file" wire:model="uploadedFiles.{{ $config->id }}" class="form-control form-control-sm mr-2" style="width: 250px;">
                                                        <button wire:click="uploadClientFile({{ $config->id }})" class="btn btn-sm btn-success" wire:loading.attr="disabled">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                                            </svg>
                                                             Subir
                                                        </button>
                                                    </div>
                                                    @error('uploadedFiles.' . $config->id) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
