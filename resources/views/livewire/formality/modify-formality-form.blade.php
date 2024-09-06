<div>
    <form wire:submit="update">
        <section>
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones asesor</label>
                    <textarea wire:model="form.assigned_observation" class="form-control"
                        id="exampleFormControlTextarea1" rows="3" name="assigned_observation"></textarea>
                </div>
            </div>
        </section>
        <section>
            <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                    Datos de trámite
                </span>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4" style="margin-bottom: 25px">
                    <div class="form-check form-switch">
                        <input wire:model="form.canClientEdit" class="form-check-input" type="checkbox" role="switch"
                            id="flexSwitchCheckChecked">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Permitir que el cliente pueda
                            editar este tramite</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Compañía suministro: </label>
                    <select wire:model.live="companyId" wire:model="companyId"
                        class="form-control @error('companyId') is-invalid @enderror" name="company_id" required>
                        <option value="0">-- seleccione --</option>
                        @foreach ($this->companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('companyId')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="">Producto compañía: </label>
                    <select wire:model="form.product_id"
                        class="form-control @error('form.product_id') is-invalid @enderror" name="product_id" required>
                        <option value="0">-- seleccione --</option>
                        @foreach ($this->products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('form.product_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if ($this->formality->service->name !== 'agua')
                    <div class="form-group col-md-2">
                        <label for="">Tarifa acceso: </label>
                        <select wire:model="form.access_rate_id"
                            class="form-control @error('form.access_rate_id') is-invalid @enderror" id="inputLocation"
                            name="access_rate_id" required>
                            <option value="0">-- seleccione --</option>
                            @if (isset($accessRate))
                                @foreach ($accessRate as $rate)
                                    <option value="{{ $rate->id }}">{{ $rate->name }}</option>
                                @endforeach

                            @endif
                        </select>
                        @error('form.access_rate_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">CUPS: </label>

                        <input wire:model="form.CUPS" type="text"
                            class="form-control @error('form.CUPS') is-invalid @enderror" id="inputZip" name="CUPS"
                            required>
                        @error('form.CUPS')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Compañía suministro anterior: </label>
                    <select wire:model="form.previous_company_id"
                        class="form-control @error('form.previous_company_id') is-invalid @enderror"
                        name="previous_company_id" required>
                        <option value="0">-- seleccione --</option>
                        @foreach ($this->companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('form.previous_company_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if (isset($this->from) && $this->from === 'total')
                    <div class="form-group col-md-3">
                        <label for="">Usuario asignado: </label>
                        <select wire:model="form.user_assigned_id"
                            class="form-control @error('form.user_assigned_id') is-invalid @enderror" id="inputLocation"
                            name="user_assigned_id" required>
                            <option value="0">-- seleccione --</option>
                            @if ($this->workers->count() > 0)
                                @foreach ($this->workers as $worker)
                                    <option value="{{ $worker->id }}">
                                        {{ ucfirst($worker->name) . ' ' . ucfirst($worker->first_last_name) . ' ' . ucfirst($worker->second_last_name) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('form.user_assigned_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif

                @if ($this->formality->service->name !== 'agua')
                    <div class="form-group col-md-3">
                        <label for="">Consumo anual: </label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                kW
                            </span>
                            <input wire:model="form.annual_consumption" type="text"
                                class="form-control @error('form.annual_consumption') is-invalid @enderror"
                                id="annual_consumption" name="annual_consumption" required>
                            @error('form.annual_consumption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Potencia: </label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                kW
                            </span>
                            <input wire:model="form.potency" type="text"
                                class="form-control @error('form.potency') is-invalid @enderror" id="potency" name="potency"
                                required>
                            @error('form.potency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>
        </section>
        @if (isset($from) && $from == 'total')
            <div>total editer</div>
        @endif
        <div style="margin-top: 50px; margin-bottom: 25px">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Observaciones internas</label>
                <textarea wire:model="form.internal_observation" class="form-control" id="exampleFormControlTextarea1"
                    rows="3" name="internal_observation"></textarea>
            </div>

        </div>
        <div class="row no-print">
            <div class="col-12">
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                        Finalizar trámite</button>
                    <button wire:click="insertData" type="button" class="btn btn-primary float-right"
                        style="margin-right: 10px"><i class="far fa-save"></i>
                        Guardar datos</button>
                </div>
            </div>
        </div>
    </form>
    <script src="/vendor/jquery/jquery.min.js"></script>
    @script
    <script>

        $(document).ready(function () {
            $("#potency").on("input", function () {
                let val = $(this).val();

                let fmt = val.toString().split(",");

                fmt[0] = fmt[0].replace(/\./g, "");
                fmt[0] = fmt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                let result = fmt.join(",");

                $(this).val(result);
            });
            $("#potency").keypress(function (event) {
                if ((event.which < 48 || event.which > 57) && event.which !== 44) {
                    event.preventDefault();
                }
            });
            $("#annual_consumption").keypress(function (event) {
                if ((event.which < 48 || event.which > 57) && event.which !== 46) {
                    event.preventDefault();
                }
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
</div>