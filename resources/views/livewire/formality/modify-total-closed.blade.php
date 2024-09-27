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
                    <a href="{{ route('admin.formality.total.closed') }}">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </a>
                    <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                        Finalizar trámite</button>
                    <button wire:click="insertData" type="button" class="btn btn-primary float-right"
                        style="margin-right: 10px"><i class="far fa-save"></i>
                        Guardar datos</button>
                    @empty($formality->reasonCancellation)
                        <button type="button" class="btn btn-danger float-right" style="margin-right: 10px"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="cancel_formality_btn"> <svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                            Baja contrato
                        </button>
                    @endempty
                </div>
            </div>
        </div>
    </form>
    <div>
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Baja de contrato</h1>
                        <button wire:click="resetCancellation" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close" id="cancel_formality_close_btn"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Fecha de finalización: </label>
                                <input wire:model="cancellation.contract_completion_date" type="date"
                                    class="form-control @error('cancellation.contract_completion_date') is-invalid @enderror"
                                    id="inputCity" name="contract_completion_date">
                                @error('cancellation.contract_completion_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Motivo de baja: </label>
                                <select wire:model="cancellation.reason_cancellation_id"
                                    class="form-control @error('cancellation.reason_cancellation_id') is-invalid @enderror"" id="
                                    inputProvince">
                                    <option value="">-- seleccione --</option>
                                    @isset ($reasonCancellation)
                                        @foreach ($reasonCancellation as $option)
                                            <option value="{{ $option->id }}">
                                                {{ ucfirst($option->name) }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('cancellation.reason_cancellation_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div style="margin-top: 30px; margin-bottom: 10px">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Observaciones de baja</label>
                                        <textarea wire:model="cancellation.cancellation_observation"
                                            class="form-control" id="exampleFormControlTextarea1" rows="3"
                                            name="cancellation_observation"></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <section x-data="{ newOne: true, }">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="form-check">
                                        <input wire:model="cancellation.create_new_one" class="form-check-input"
                                            type="checkbox" value="0" id="create_new_one" x-on:click="newOne = !newOne">
                                        <label class="form-check-label" for="invalidCheck2">
                                            Dar de alta nuevo trámite para este sumistro
                                        </label>
                                        @error('days_to_renew')
                                            <div class="form-row">
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <section x-show="!newOne">
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="inputState">Asignar usuario: </label>
                                        <select wire:model="cancellation.assignedId"
                                            class="form-control @error('cancellation.assignedId') is-invalid @enderror"
                                            id="assignedId" required>
                                            <option value="">-- seleccione --</option>
                                            @if ($this->workers->count() > 0)
                                                @foreach ($this->workers as $worker)
                                                    <option value="{{ $worker->id }}">
                                                        {{ ucfirst($worker->name) . ' ' . ucfirst($worker->first_last_name) . '
                                                                                                                                                                                                                                                                    ' . ucfirst($worker->second_last_name) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('cancellation.assignedId')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <div class="form-check">
                                            <input wire:model="cancellation.isCritical" class="form-check-input"
                                                type="checkbox" value="0" id="isCritical">
                                            <label class="form-check-label" for="invalidCheck2">
                                                Trámite Crítico
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>

                        <div class="row no-print">
                            <div class="col-12">
                                <div style="margin-top: 50px; margin-bottom: 25px">
                                    <div class="">
                                        <button wire:click="resetCancellation" type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal" id="cancel_formality_close_down_btn">Cerrar</button>
                                        <button wire:click="cancelFormality" type="button"
                                            class="btn btn-success float-right"><i class="far fa-save"></i>
                                            Dar de baja</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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

            $("#cancel_formality_close_btn, #cancel_formality_close_down_btn").click(function () {
                if ($("#create_new_one").is(":checked")) {
                    $("#create_new_one").click();
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