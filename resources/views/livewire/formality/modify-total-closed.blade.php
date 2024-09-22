<div>
    <form wire:submit="update">
        <section>
            <div class="form-row" style="margin-top: 50px; margin-bottom: 25px">
                <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                    Datos editables
                </span>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4" style="margin-bottom: 25px">
                    <div class="form-check form-switch">
                        <input wire:model="form.isRenewable" wire:change="setIsRenewable()" class="form-check-input"
                            type="checkbox" role="switch" id="isRenewable">
                        <label class="form-check-label" for="isRenewable">Renovación</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Comisión bruta: </label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-currency-euro" viewBox="0 0 16 16">
                                <path
                                    d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936q-.002-.165.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.6 6.6 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z" />
                            </svg>
                        </span>
                        <input wire:model="form.commission" type="text"
                            class="form-control @error('form.commission') is-invalid @enderror" id="commission"
                            name="commission">
                        @error('form.commission')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Fecha de activación: </label>
                    <input wire:model="form.activation_date" wire:change="setContractCompletionDate()" type="date"
                        class="form-control @error('form.activation_date') is-invalid @enderror" id="inputCity"
                        name="activation_date">
                    @error('form.activation_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Fecha de finalización: </label>
                    <input wire:model="form.contract_completion_date" type="date"
                        class="form-control @error('form.contract_completion_date') is-invalid @enderror" id="inputCity"
                        name="contract_completion_date">
                    @error('form.contract_completion_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if ($form->isRenewable)
                    <div class="form-group col-md-3">
                        <label for="inputState">Fecha de renovación: </label>
                        <input wire:model="form.renewal_date" type="date"
                            class="form-control @error('form.renewal_date') is-invalid @enderror" id="renewal_date"
                            name="renewal_date">
                        @error('form.renewal_date')
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
                                id="annual_consumption" name="annual_consumption">
                            @error('form.annual_consumption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <section>
            <div class="form-group">
                @if (isset($formality->reasonCancellation))
                    <div class="form-group col-md-3">
                        <label for="">Motivo baja: </label>
                        <select wire:model="form.reason_cancellation_id"
                            class="form-control @error('form.reason_cancellation_id') is-invalid @enderror"
                            name="reason_cancellation_id" id="reason_cancellation_id">
                            <option value="">-- seleccione --</option>
                            @isset($reasonCancellation)
                                @foreach ($reasonCancellation as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        @error('form.reason_cancellation_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div style="margin-top: 50px; margin-bottom: 25px">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Observaciones de baja</label>
                            <textarea wire:model="form.cancellation_observation" class="form-control"
                                id="exampleFormControlTextarea1" rows="3" name="cancellation_observation"></textarea>
                        </div>

                    </div>
                @endif
            </div>
        </section>
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

            function formatNumber(input) {
                let val = input.val();

                let fmt = val.toString().split(",");

                fmt[0] = fmt[0].replace(/\./g, "");
                fmt[0] = fmt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                let result = fmt.join(",");

                input.val(result);
            }

            $("#potency").on("input", function () {
                formatNumber($(this));
            });
            $("#annual_consumption").on("input", function () {
                formatNumber($(this));
            });

            $("#commission").on("input", function () {
                formatNumber($(this));
            });

            $("#commission").keypress(function (event) {
                if ((event.which < 48 || event.which > 57) && event.which !== 44) {
                    event.preventDefault();
                }
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
                if (event.which === 46) {
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