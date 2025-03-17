<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success float-right btn-sm" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        <i class="far fa-plus-square"></i> Agregar comercializadora
    </button>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Crear comercializadora</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Nombre de comercializadora: </label>
                                <input wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" id="inputAddress"
                                    placeholder="" name="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Dia para renovación: </label>
                                <input wire:model="days_to_renew" type="text"
                                    class="form-control @error('days_to_renew') is-invalid @enderror" id="inputAddress"
                                    placeholder="" name="days_to_renew">
                                @error('days_to_renew')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                            Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>