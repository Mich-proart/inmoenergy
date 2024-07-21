<div>
    <form wire:submit="update">
        <section>
            <div style="margin-top: 50px; margin-bottom: 25px">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Observaciones del tramitador</label>
                    <textarea wire:model="form.issuer_observation" class="form-control" id="exampleFormControlTextarea1"
                        rows="3" name="observation"></textarea>
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
                    <select wire:model.live="companyId"
                        class="form-control @error('form.company_id') is-invalid @enderror" name="company_id" required>
                        <option value="">-- seleccione --</option>
                        @foreach ($this->companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
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
                        class="form-control @error('form.product_id') is-invalid @enderror" name="product_id" required>
                        <option value="">-- seleccione --</option>
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
                <div class="form-group col-md-2">
                    <label for="">Tarifa acceso: </label>
                    <select wire:model="form.access_rate_id"
                        class="form-control @error('form.access_rate_id') is-invalid @enderror" id="inputLocation"
                        name="access_rate_id" required>
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
                        class="form-control @error('form.CUPS') is-invalid @enderror" id="inputZip" name="CUPS"
                        required>
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
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            KW
                        </span>
                        <input wire:model="form.annual_consumption" type="text"
                            class="form-control @error('form.annual_consumption') is-invalid @enderror" id="inputZip"
                            name="annual_consumption" required>
                        @error('form.annual_consumption')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

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
                            name="commission" required>
                        @error('form.commission')
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
                            KW
                        </span>
                        <input wire:model="form.potency" type="text"
                            class="form-control @error('form.potency') is-invalid @enderror" id="inputZip"
                            name="potency" required>
                        @error('form.potency')
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
</div>