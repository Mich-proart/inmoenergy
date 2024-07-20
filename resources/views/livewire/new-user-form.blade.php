<div>
    @section('plugins.select2', true)
    <div class="card card-primary card-outline">
        <div class="card-body">
            <form wire:submit="save">
                @csrf
                <section>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Datos personales
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputState">Tipo Cliente: </label>
                            <select wire:model="form.clientTypeId"
                                class="form-control @error('form.clientTypeId') is-invalid @enderror"
                                name="clientTypeId">
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
                            <label for="inputCity">Nombre</label>
                            <input wire:model="form.name" type="text"
                                class="form-control @error('form.name') is-invalid @enderror" id="inputCity"
                                name="name">
                            @error('form.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputState">Primer apellido: </label>
                            <input wire:model="form.firstLastName" type="text"
                                class="form-control @error('form.firstLastName') is-invalid @enderror" id="inputCity"
                                name="firstLastName">
                            @error('form.firstLastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputZip">Segundo apellido: </label>
                            <input wire:model="form.secondLastName" type="text" class="form-control" id="inputZip"
                                name="secondLastName">
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
                                name="documentTypeId">
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
                            <input wire:model="form.phone" type="text"
                                class="form-control @error('form.phone') is-invalid @enderror" id="inputAddress"
                                placeholder="" name="phone">
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
                                name="email">
                            @error('form.email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class=" form-group col-md-3">
                            <label for="inputAddress2">Permisos: </label>
                            <select wire:model="form.roleId"
                                class="form-control @error('form.roleId') is-invalid @enderror" name="roleId">
                                <option value="">-- selecione --</option>
                                @if (isset($roles))
                                    @foreach ($roles as $option)
                                        <option value="{{ $option->id }}">{{ ucfirst($option->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('form.roleId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class=" form-group col-md-3">
                            <label for="inputAddress2">Contraseña: </label>
                            <input wire:model="form.password" type="text"
                                class="form-control @error('form.password') is-invalid @enderror" id="inputAddress2"
                                placeholder="" name="password">
                            @error('form.password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class=" form-group col-md-3" style="margin-top: 30px">
                            <button class="btn btn-primary" type="button" wire:click="generatePassword">Generar</button>
                        </div>

                    </div>
                </section>
                <section>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Dirección
                        </span>
                    </div>

                    <!-- street group -->
                    <div class="row">
                        <!-- street type -->
                        <div class="col-md-2">
                            <label for="inputZip">Tipo de calle: </label>
                            <select wire:model="form.streetTypeId"
                                class="form-control @error('form.streetTypeId') is-invalid @enderror"
                                name="streetTypeId">
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
                                name="streetName">
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
                                name="streetNumber">
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
                                name="locationId">
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
                @if (!$this->form->isWorker)
                    <section>
                        <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                            <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                                Datos cliente
                            </span>
                        </div>
                        <div wire:ignore class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputState">Tipo incentivo: </label>
                                <select wire:model="form.incentiveTypeTd"
                                    class="form-control @error('form.incentiveTypeTd') is-invalid @enderror"
                                    name="incentiveTypeTd">
                                    <option value="">-- selecione --</option>
                                    @if (isset($incentiveTypes))
                                        @foreach ($incentiveTypes as $type)
                                            <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('form.incentiveTypeTd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Grupo empresarial: </label>
                                <select wire:model.live="business_target"
                                    class="form-control @error('form.businessGroup') is-invalid @enderror"
                                    name="businessGroup" id="businessGroup">
                                    <option value="">-- selecione --</option>
                                    @if (isset($this->business))
                                        @foreach ($this->business as $option)
                                            <option value="{{ $option->name }}">{{ $option->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('form.businessGroup')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputCity">Oficina usuario</label>
                                <select wire:model="form.office"
                                    class="form-control @error('form.office') is-invalid @enderror" name="office"
                                    id="office">
                                    <option value="">-- selecione --</option>
                                    @if (isset($this->offices))
                                        @foreach ($this->offices as $option)
                                            <option value="{{ $option->name }}">{{ $option->name }}</option>
                                        @endforeach

                                    @endif

                                </select>
                                @error('form.office')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputState">Asesor asignado: </label>
                                <select wire:model="form.adviserAssignedId"
                                    class="form-control @error('form.adviserAssignedId') is-invalid @enderror"
                                    name="adviserAssignedId">
                                    <option value="">-- selecione --</option>
                                    @if (isset($advisers))
                                        @foreach ($advisers as $adviser)
                                            <option value="{{ $adviser->id }}">
                                                {{ ucfirst($adviser->name . ' ' . $adviser->first_last_name . ' ' . $adviser->second_last_name) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('form.adviserAssignedId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </section>
                @endif
                <div class="row no-print">
                    <div class="col-12">
                        <div style="margin-top: 50px; margin-bottom: 25px">
                            <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                                Crear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>


</div>

@script
<script>

    $(document).ready(function () {
        $('#businessGroup').select2({
            tags: true
        });
        $('#office').select2({
            tags: true
        });

        $('#businessGroup').on('change', function (event) {
            $wire.$set('business_target', event.target.value)
            console.log(event.target.value)
        });
    });
</script>
@endscript