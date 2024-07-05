<div>
    <form wire:submit="update">
        <section>
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones del tramitador</label>
                    <textarea wire:model="form.issuer_observation" class="form-control" id="exampleFormControlTextarea1"
                        rows="3" name="observation" disabled></textarea>
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
                    <select wire:model="form.company_id"
                        class="form-control @error('form.company_id') is-invalid @enderror" name="company_id">
                        <option value="">-- seleccione --</option>

                    </select>
                    @error('form.company_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="">Producto compañía: </label>
                    <select wire:model="form.product_id"
                        class="form-control @error('form.product_id') is-invalid @enderror" name="product_id">
                        <option value="">-- seleccione --</option>

                    </select>
                    @error('form.product_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label for="">Tarifa acceso: </label>
                    <select wire:model="form.access_rate_id"
                        class="form-control @error('form.access_rate_id') is-invalid @enderror" id="inputLocation"
                        name="access_rate_id">
                        <option value="">-- seleccione --</option>
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
                        class="form-control @error('form.CUPS') is-invalid @enderror" id="inputZip" name="CUPS">
                    @error('form.CUPS')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Consumo anual: </label>
                    <input wire:model="form.annual_consumption" type="text"
                        class="form-control @error('form.annual_consumption') is-invalid @enderror" id="inputZip"
                        name="annual_consumption">
                    @error('form.annual_consumption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="">Comisión bruta: </label>
                    <input wire:model="form.commission" type="text"
                        class="form-control @error('form.commission') is-invalid @enderror" id="inputZip"
                        name="commission">
                    @error('form.commission')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="">Potencia: </label>
                    <input wire:model="form.potential" type="text"
                        class="form-control @error('form.potential') is-invalid @enderror" id="inputZip"
                        name="potential">
                    @error('form.potential')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
                </div>
            </div>
        </div>
    </form>
</div>