<div>
    <div class="spinner-wrapper" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @error('form.formalityTypeId')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @enderror
    @error('form.serviceIds')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @enderror

    <div class="card card-primary card-outline">
        <div class="card-body">
            <form wire:submit="save">
                @csrf
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
                                            <input wire:model="form.formalityTypeId" class="form-check-input" type="radio" id=""
                                                name="formalityTypeId" value="{{ $formalitytype->id }}" required>
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
                                <label for="">¿Qué suministro quieres tramitar? (Selecciona uno o varios).</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @if (isset($services))
                                    @foreach ($services as $service)
                                        <div class="form-check form-check-inline">
                                            <input wire:model="form.serviceIds" class="form-check-input" type="checkbox" id=""
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
                <section x-data="{ type: '' }">
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">

                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Datos del Cliente
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Tipo Cliente: </label>
                            <select wire:model="form.clientTypeId" wire:change="formstate" x-model="type"
                                class="form-control @error('form.clientTypeId') is-invalid @enderror"
                                name="clientTypeId" id="clientTypeId" required>
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
                            <select wire:model="form.userTitleId"
                                class="form-control @error('form.userTitleId') is-invalid @enderror" name="userTitleId"
                                id="userTitleId" :disabled="type === '{{$businessClientType->id}}'" :required="type !== '{{$businessClientType->id}}'">
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
                            <input wire:model="form.firstLastName" type="text"
                                class="form-control @error('form.firstLastName') is-invalid @enderror"
                                name="firstLastName" id="first-LastName"
                                :disabled="type === '{{$businessClientType->id}}'" :required="type !== '{{$businessClientType->id}}'">
                            @error('form.firstLastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputZip">Segundo apellido: </label>
                            <input wire:model="form.secondLastName" type="text" class="form-control"
                                name="secondLastName" id="second-LastName"
                                :disabled="type === '{{$businessClientType->id}}'" :required="type !== '{{$businessClientType->id}}'">
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
                            <select wire:model="form.documentTypeId"
                                class="form-control @error('form.documentTypeId') is-invalid @enderror"
                                name="documentTypeId" id="documentTypeId"
                                :disabled="type === '{{$businessClientType->id}}'">
                                <option value="0">-- selecione --</option>
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
                                name="documentNumber" required>
                            @error('form.documentNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Teléfono: </label>
                            <input wire:model="form.phone" type="text"
                                class="form-control @error('form.phone') is-invalid @enderror" id="inputAddress"
                                placeholder="" name="phone" required>
                            @error('form.phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                        <input wire:model="form.IBAN" type="text"
                            class="form-control @error('form.IBAN') is-invalid @enderror" id="inputAddress2"
                            placeholder="" name="IBAN" required>
                        @error('form.IBAN')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                                name="housingTypeId" required>
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
                                name="zipCode" required>
                            @error('form.zipCode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </section>
                <section x-data="{ buttonDisabled: true, }">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 25px">
                                <div class="form-check">
                                    <input wire:model="form.is_same_address" class="form-check-input" type="checkbox"
                                        value="0" id="is_same_address" x-on:click="buttonDisabled = !buttonDisabled">
                                    <label class="form-check-label" for="invalidCheck2">
                                        La dirección de correspondencia es la misma que la dirección de suministro.
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <section x-show="!buttonDisabled">
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
                                        id="client_block" name="client_block" x-bind:disabled="buttonDisabled">
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
                                        id="client_floor" name="client_floor" x-bind:disabled="buttonDisabled">
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
                                        id="client_door" name="client_door" x-bind:disabled="buttonDisabled">
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
                </section>
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones del trámite</label>
                        <textarea wire:model="form.observation" class="form-control" id="exampleFormControlTextarea1"
                            rows="3" name="observation"></textarea>
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
                <div class="row no-print">
                    <div class="col-12">
                        <div style="margin-top: 50px; margin-bottom: 25px">
                            <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                                Tramitar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {

            if ($('#is_same_address').is(':checked')) {
                $('#collapseTwo').removeClass('show');
            }

            $('#is_same_address').on('change', function () {
                $('#collapseTwo').toggleClass('show');
            })

            const is_same_address_field = [
                '#client_locationId',
                '#client_housingTypeId',
                '#client_streetTypeId',
                '#client_streetName',
                '#client_streetNumber',
                '#client_zipCode'
            ];
            const corresponced_address_field = is_same_address_field.concat([
                '#client_inputProvince',
                '#client_block',
                '#client_blockstaircase',
                '#client_floor',
                '#client_door'
            ])
            $('#is_same_address').on('change', function () {
                const select = $('#is_same_address').is(':checked');

                is_same_address_field.forEach(element => {
                    $(element).prop('required', !select);
                })

                if (select === true) {
                    $('#client_inputProvince').val(0);
                    corresponced_address_field.forEach(element => $(element).val(''))
                }
            })
        });
    </script>
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
        })

    </script>
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

        $wire.on('load', () => {
            // document.querySelector('.spinner-wrapper').style.display = 'block';
        })
    </script>
    @endscript
</div>