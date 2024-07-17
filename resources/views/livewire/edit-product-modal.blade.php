<div>
    <!-- Button trigger modal -->
    <button type="button" id="edit_renovation_btn" class="btn btn-primary float-right" data-bs-toggle="modal"
        data-bs-target="#edit-product-modal"><i class="far fa-plus-square"></i> Agregar producto</button>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="edit-product-modal" tabindex="-1"
        aria-labelledby="edit-product-modal-Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit-product-modal-Label">Editar producto
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Comercializadora: </label>
                                <select wire:model="companyId"
                                    class="form-control @error('companyId') is-invalid @enderror" name="companyId"
                                    required>
                                    <option value="">-- selecione --</option>
                                    @if (isset($companies))
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ ucfirst($company->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('companyId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Nombre del producto: </label>
                                <input id="name" type="text" wire:model="name" value=""
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                                Guardar cambios</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>