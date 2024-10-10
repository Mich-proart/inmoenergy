<div>
    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3">
            <div class="col-12 ">
                <h4>
                    @livewire('ticket.get-ticket-modal', ['formality' => $formality, 'to' => 'admin.ticket.edit', 'from' => 'admin.formality.inprogress', 'checkStatus' => false])
                </h4>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit="update">
                <section>
                    <div class="form-group">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <label for=""> Usuario asignado: </label> @if (isset($formality->assigned))
                                    {{$formality->assigned->name}}
                                @endif
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <label for="">Fecha:</label> {{$formality->created_at}}
                            </div>
                            <div id="status" class="col-sm-4 invoice-col">
                                <label for="">Estado:</label>
                                @if (isset($formality->status))
                                    @if ($formality->status->name == "pendiente asignación" || $formality->status->name === "asignado")
                                        <span class="custom-badge assigned">{{$formality->status->name}}</span>
                                    @endif

                                    @if ($formality->status->name == "K.O.")
                                        <span class="custom-badge ko">{{$formality->status->name}}</span>
                                    @endif
                                    @if ($formality->status->name == "en curso")
                                        <span class="custom-badge inprogress">{{$formality->status->name}}</span>
                                    @endif
                                    @if ($formality->status->name == "tramitado")
                                        <span class="custom-badge processed">{{$formality->status->name}}</span>
                                    @endif
                                    @if ($formality->status->name == "en vigor")
                                        <span class="custom-badge operative">{{$formality->status->name}}</span>
                                    @endif
                                @endif
                            </div>

                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <label for=""> Compañía suministro: </label>
                                @if (isset($formality->product) && isset($formality->product->company))
                                    {{ucfirst($formality->product->company->name)}}
                                @endif
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <label for="">Producto Compañía:</label> @if (isset($formality->product))
                                    {{ucfirst($formality->product->name)}}
                                @endif
                            </div>


                        </div>
                    </div>
                </section>
                <section>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="">Tipo de trámite</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col ">
                                @if (isset($formalitytypes))
                                    @foreach ($formalitytypes as $formalitytype)
                                        <div class="form-check form-check-inline">
                                            <input wire:model="form.formalityTypeId" class="form-check-input" type="radio" id=""
                                                name="formalityTypeId" value="{{ $formalitytype->id }}">
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
                                <label for="">Suministro tramitado.</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @if (isset($services))
                                    @foreach ($services as $service)
                                        <div class="form-check form-check-inline">
                                            <input wire:model="form.serviceIds" class="form-check-input" type="radio" id=""
                                                name="serviceIds[]" wire:click="addInput({{ $service->id }})"
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
                            Datos del Cliente
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Tipo Cliente: </label>
                            <select wire:model="form.clientTypeId" wire:change="formstate"
                                class="form-control @error('form.clientTypeId') is-invalid @enderror"
                                name="clientTypeId" id="clientTypeId">
                                <option value="">-- selecione --</option>
                                @if (isset($clientTypes))
                                    @foreach ($clientTypes as $clientType)
                                        <option value="{{ $clientType->id }}">{{ ucfirst($clientType->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('form.clientTypeId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-1">
                            <label for="inputState">Título: </label>
                            <select wire:model="form.userTitleId" {{$isBusinessPerson ? '' : 'required'}}
                                {{$isBusinessPerson ? 'disabled' : ''}}
                                class="form-control @error('form.userTitleId') is-invalid @enderror" name="userTitleId">
                                <option value="">-- selecione --</option>
                                @if (isset($userTitles))
                                    @foreach ($userTitles as $userTitle)
                                        <option value="{{ $userTitle->id }}">{{ $userTitle->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('form.userTitleId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputCity">{{$field_name}}</label>
                            <input wire:model="form.name" type="text"
                                class="form-control @error('form.name') is-invalid @enderror" id="inputCity" name="name"
                                required>
                            @error('form.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputState">Primer apellido: </label>
                            <input wire:model="form.firstLastName" type="text" {{$isBusinessPerson ? '' : 'required'}}
                                {{$isBusinessPerson ? 'disabled' : ''}}
                                class="form-control @error('form.firstLastName') is-invalid @enderror" id="inputCity"
                                name="firstLastName" id="first-LastName">
                            @error('form.firstLastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputZip">Segundo apellido: </label>
                            <input wire:model="form.secondLastName" {{$isBusinessPerson ? 'disabled' : ''}} type="text"
                                {{$isBusinessPerson ? '' : 'required'}}
                                class="form-control @error('form.secondLastName') is-invalid @enderror"
                                id="second-LastName" name="secondLastName">
                            @error('form.secondLastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputState">Tipo documento: </label>
                            <select wire:model="form.documentTypeId" {{$isBusinessPerson ? 'disabled' : ''}}
                                class="form-control @error('form.documentTypeId') is-invalid @enderror"
                                name="documentTypeId" required id="documentTypeId">
                                <option value="">-- selecione --</option>
                                @if (isset($documentTypes))
                                    @foreach ($documentTypes as $option)
                                        <option value="{{ $option->id }}">{{ ucfirst($option->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('form.documentTypeId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputState">Número documento: </label>
                            <input wire:model="form.documentNumber" type="text"
                                class="form-control @error('form.documentNumber') is-invalid @enderror" id="inputZip"
                                name="documentNumber">
                            @error('form.documentNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Teléfono: </label>
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img
                                        src="https://flagsapi.com/{{$selected_country->iso2}}/flat/16.png">+{{$selected_country->phone_code}}</button>
                                <ul class="dropdown-menu">
                                    @isset($countries)
                                        @foreach ($countries as $country)
                                            <li wire:click="changeCountry({{$country->id}})"><a class="dropdown-item" href="#">
                                                    <img src="https://flagsapi.com/{{$country->iso2}}/flat/16.png">
                                                    {{$country->name_spanish}}
                                                    +{{$country->phone_code}}
                                                </a></li>
                                        @endforeach
                                    @endisset
                                </ul>
                                <input wire:model="form.phone" type="text"
                                    class="form-control @error('form.phone') is-invalid @enderror" id="phone"
                                    placeholder="" name="phone">
                                @error('form.phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputZip">Email: </label>
                            <input wire:model="form.email" type="text"
                                class="form-control @error('form.email') is-invalid @enderror" id="inputZip"
                                name="email" required>
                            @error('form.email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class=" form-group">
                        <label for="inputAddress2">Cuenta Bancaria: </label>
                        <input wire:model="form.IBAN" type="text" class="form-control" id="inputAddress2" placeholder=""
                            name="IBAN" required>
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
                            <select wire:model="form.streetTypeId"
                                class="form-control @error('form.streetTypeId') is-invalid @enderror"
                                name="streetTypeId" required>
                                <option value="">-- seleccione --</option>
                                @if (isset($streetTypes))
                                    @foreach ($streetTypes as $streetType)
                                        <option value="{{ $streetType->id }}">{{ ucfirst($streetType->name) }}</option>
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
                                class="form-control @error('form.streetName') is-invalid @enderror" id="inputZip"
                                name="streetName" required>
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
                                class="form-control @error('form.streetNumber') is-invalid @enderror" id="inputZip"
                                name="streetNumber" required>
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
                                class="form-control @error('form.block') is-invalid @enderror" id="inputZip"
                                name="block">
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
                                class="form-control @error('form.blockstaircase') is-invalid @enderror" id="inputZip"
                                name="blockstaircase">
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
                                class="form-control @error('form.floor') is-invalid @enderror" id="inputZip"
                                name="floor">
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
                                class="form-control @error('form.door') is-invalid @enderror" id="inputZip" name="door">
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
                                name="housingTypeId">
                                <option value="">-- selecione --</option>
                                @if (isset($housingTypes))
                                    @foreach ($housingTypes as $housingType)
                                        <option value="{{ $housingType->id }}">{{ ucfirst($housingType->name) }}</option>
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
                            <select wire:model.live="target_provinceId" class="form-control" id="inputProvince">
                                <option value="">-- seleccione --</option>
                                @foreach ($this->provinces as $province)
                                    @if ($province->region->name === $province->name)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @else
                                        <option value="{{ $province->id }}">{{ $province->region->name }}, {{ $province->name }}
                                        </option>
                                    @endif

                                @endforeach
                            </select>
                        </div>
                        <!-- location -->
                        <div class="col-md-3">
                            <label for="inputState">Población: </label>
                            <select wire:model="form.locationId"
                                class="form-control @error('form.locationId') is-invalid @enderror" id="inputLocation"
                                name="locationId" required>
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
                                class="form-control @error('form.zipCode') is-invalid @enderror" id="inputZip"
                                name="zipCode">
                            @error('form.zipCode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                </section>
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
                                    name="client_streetTypeId" id="client_streetTypeId" {{ $same_address ? '' : 'required'}}>
                                    <option value="">-- seleccione --</option>
                                    @if (isset($streetTypes))
                                        @foreach ($streetTypes as $streetType)
                                            <option value="{{ $streetType->id }}">{{ ucfirst($streetType->name) }}</option>
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
                                    id="client_streetName" name="client_streetName" {{ $same_address ? '' : 'required'}}>
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
                                    id="client_streetNumber" name="client_streetNumber" {{ $same_address ? '' : 'required'}}>
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
                                    id="client_block" name="client_block">
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
                                    id="client_blockstaircase" name="client_blockstaircase">
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
                                    id="client_floor" name="client_floor">
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
                                    id="client_door" name="client_door">
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
                                    name="client_housingTypeId" id="client_housingTypeId" {{ $same_address ? '' : 'required'}}>
                                    <option value="">-- selecione --</option>
                                    @if (isset($housingTypes))
                                        @foreach ($housingTypes as $housingType)
                                            <option value="{{ $housingType->id }}">{{ ucfirst($housingType->name) }}</option>
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

                            <div class="col-md-3">
                                <label for="inputState">Provincia: </label>
                                <select wire:model.live="target_clientProvinceId" class="form-control"
                                    id="client_inputProvince" {{ $same_address ? '' : 'required'}}>
                                    <option value="">-- seleccione --</option>
                                    @foreach ($this->clientProvinces as $province)
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

                            <!-- client location -->
                            <div class="col-md-3">
                                <label for="inputState">Población: </label>
                                <select wire:model="form.client_locationId"
                                    class="form-control @error('form.client_locationId') is-invalid @enderror"
                                    id="client_locationId" name="client_locationId" {{ $same_address ? '' : 'required'}}>
                                    <option value="">-- seleccione --</option>
                                    @foreach ($this->clientLocations as $clientLocation)
                                        <option value="{{ $clientLocation->id }}">{{ $clientLocation->name }}</option>
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
                                    id="client_zipCode" name="client_zipCode" {{ $same_address ? '' : 'required'}}>
                                @error('form.client_zipCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones del trámite</label>
                        <textarea wire:model="form.observation" class="form-control" id="exampleFormControlTextarea1"
                            rows="3" name="observation"></textarea>
                    </div>

                </div>
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones asesor</label>
                        <textarea wire:model="form.assigned_observation" class="form-control"
                            id="exampleFormControlTextarea1" rows="3" name="assigned_observation" disabled></textarea>
                    </div>

                </div>
                <section>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Documentos
                        </span>
                    </div>
                    <div class="form-group">
                        <x-table.table :headers="['Concepto', 'Nombre', ['align' => 'center', 'name' => 'Descargar']]">
                            @isset ($files)
                                @foreach ($files as $file)
                                    <tr class="table-light">
                                        <x-table.td>{{ ucfirst($file->config->name) }}</x-table.td>
                                        <x-table.td>{{ $file->filename }}</x-table.td>
                                        <x-table.td align="center">
                                            <a href="{{route('admin.documents.download', $file->id)}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                </svg>
                                            </a>
                                        </x-table.td>
                                    </tr>
                                @endforeach
                            @endisset
                        </x-table.table>
                        <section x-data="{ buttonDisabled: true, }">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 25px">
                                        <div class="form-check">
                                            <div class="form-check form-switch">
                                                <input wire:model="form.new_files" class="form-check-input"
                                                    type="checkbox" role="switch"
                                                    x-on:click="buttonDisabled = !buttonDisabled"
                                                    id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Editar
                                                    archivos existentes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if ($service_file)
                                    @foreach($service_file as $key => $file)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="inputZip">{{ucfirst($file['name'])}}: </label>
                                                <input wire:model.defer="service_file.{{$key}}.file" type="file"
                                                    class="form-control @error('service_file.' . $key . '.file') is-invalid @enderror"
                                                    id="input_{{$key}}_file">
                                                @error('service_file.' . $key . '.file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <div wire:loading wire:target="service_file.{{$key}}.file">Subiendo
                                                    archivo...
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <section x-show="!buttonDisabled">
                                @if ($inputs)
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
                                                <div wire:loading wire:target="inputs.{{$key}}.file">Subiendo archivo...
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </section>
                        </section>
                    </div>
                </section>
                <div class="row no-print">
                    <div class="col-12">
                        <div style="margin-top: 50px; margin-bottom: 25px">
                            <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                                Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/custom/badge.code.js"></script>
</div>

@script
<script>
    $(document).ready(function () {



        $('#clientTypeId').on('change', function () {
            const select = $('#clientTypeId').val();
            if (select === '{{$businessClientType->id}}') {
                setTimeout(() => {
                    $('#documentTypeId').val('{{$businessDocumentType->id}}');
                }, 500);
                $('#first-LastName').val('');
                $('#second-LastName').val('');
                $('#userTitleId').val('');
            } else {
                $('#documentTypeId').val(0);
            }
        })

        $("#client_inputProvince").on("change", function () {
            setTimeout(function () {
                $("#client_locationId").val("");
            }, 200);

        });
        $("#inputProvince").on("change", function () {
            setTimeout(function () {
                $("#inputLocation").val("");
            }, 200);

        });

    });

    $wire.on('checks', (e) => {
        console.log(e);
        Swal.fire({
            confirmButtonColor: '#004a99',
            icon: "error",
            title: e.title,
            text: e.error,
        });
    });
</script>
@endscript