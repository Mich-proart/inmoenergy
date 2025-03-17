<div>
    <div x-data="{ buttonDisabled: true }" class="card card-success card-outline">
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
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img
                                        src="https://flagsapi.com/{{$selected_country->iso2}}/flat/16.png">+{{$selected_country->phone_code}}
                                </button>
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
                            <label for="inputAddress2">Nueva Contraseña: </label>
                            <input wire:model="form.password" type="password"
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 25px">
                                <div class="form-check">
                                    <input wire:model="form.isActive" class="form-check-input" type="checkbox" value="0"
                                        id="isActive" wire:change="changeStatus">
                                    <label class="form-check-label" for="invalidCheck2">
                                        Usuario activo
                                    </label>

                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputZip">Fecha de baja: </label>
                                <input wire:model="form.disabledAt" type="date"
                                    class="form-control @error('form.disabledAt') is-invalid @enderror" id="disabledAt"
                                    name="disabledAt" {{ $isActive ? 'disabled' : '' }}>
                                @error('form.disabledAt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </section>
                <section>
                    <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                            Dirección
                        </span>
                    </div>
                    <div class="row">
                        <!-- region -->
                        <div class="col-md-3">
                            <label for="inputState">Comunidad autónoma: </label>
                            <select wire:model.live="target_regionId" class="form-control" id="target_region_id"
                                required>
                                <option value="">-- seleccione --</option>
                                @foreach ($this->regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- province -->
                        <div class="col-md-3">
                            <label for="inputState">Provincia: </label>
                            <select wire:model.live="target_provinceId" class="form-control" id="target_province_id"
                                required>
                                <option value="">-- seleccione --</option>
                                @foreach ($this->provinces as $province)
                                    @if ($province->region->name === $province->name)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @else
                                        <option value="{{ $province->id }}">{{ $province->region->name }}
                                            , {{ $province->name }}
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
                                id="tartet_location_id" name="locationId" required>
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
                    <div class="col-md-6">
                        <label for="inputZip">Dirección: </label>
                        <input wire:model="form.full_address" type="text"
                            class="form-control @error('form.full_address') is-invalid @enderror" id="full_address"
                            name="full_address">
                        @error('form.full_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </section>
                @if (!$this->form->isWorker)
                    <section>
                        <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                            <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                                Datos cliente
                            </span>
                        </div>
                        <div class="form-row">
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
                                            <option value="{{ $option->id }}">{{ $option->name }}</option>
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
                                <select wire:model="officeId" class="form-control @error('officeId') is-invalid @enderror"
                                    name="officeId" id="officeId">
                                    <option value="">-- selecione --</option>
                                    @foreach ($office_list as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                                @error('officeId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3" style="display: none">
                                <label for="inputCity">Oficina usuario</label>
                                <input wire:model="form.officeName" type="text"
                                    class="form-control @error('form.officeName') is-invalid @enderror" id="officeName"
                                    name="officeName">
                                @error('form.officeName')
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
                            <div class="form-group col-md-3" style="display: none">
                                <label for="inputState">Nombre responsable: </label>
                                <select wire:model="form.responsibleId"
                                    class="form-control @error('form.responsibleId') is-invalid @enderror"
                                    name="responsibleId">
                                    <option value="">-- selecione --</option>
                                    @if (isset($advisers))
                                        @foreach ($advisers as $adviser)
                                            <option value="{{ $adviser->id }}">
                                                {{ ucfirst($adviser->name . ' ' . $adviser->first_last_name . ' ' . $adviser->second_last_name) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('form.responsibleId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Nombre responsable: </label>
                                <input wire:model="form.responsibleName" type="text"
                                    class="form-control @error('form.responsibleName') is-invalid @enderror"
                                    id="responsibleName" name="responsibleName">
                                @error('form.responsibleName')
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
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    </div>
    <script src="http://127.0.0.1:8000/vendor/jquery/jquery.min.js"></script>
    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            function LoadDropdown() {

                $('#businessGroup').on('change', function (event) {
                    $wire.$set('business_target', event.target.value)
                    $wire.dispatch('change-businessGroup')
                    console.log(event.target.value)

                });
                $('#officeId').select2({
                    tags: true
                }).on('change', function (event) {
                    $wire.$set('officeId', event.target.value)

                });
            }
            LoadDropdown()

            Livewire.hook('morph.updating', () => {
                LoadDropdown()
                console.log('morph.updating')
            })
        })
        $(document).ready(function () {
            const target_region = ["#target_province_id", "#tartet_location_id"];
            const target_province = ["#tartet_location_id"];


            $("#target_region_id").on("change", function () {
                target_region.forEach((element) => {
                    setTimeout(function () {
                        $(element).val("").trigger("change");
                    }, 200);

                })
            });

            $("#target_province_id").on("change", function () {
                target_province.forEach((element) => {
                    setTimeout(function () {
                        $(element).val("").trigger("change");
                    }, 200);
                })

            });

            $('#phone').keypress(function (event) {
                if ((event.which < 48 || event.which > 57) && event.which !== 46) {
                    event.preventDefault();
                }
                if (event.which === 46) {
                    event.preventDefault();
                }
            });

        })
        $wire.on('msg', (e) => {
            console.log(e);
            Swal.fire({
                confirmButtonColor: '#004a99',
                icon: e.type,
                title: e.title,
                text: e.error,
            });
        });
    </script>
    @endscript
</div>