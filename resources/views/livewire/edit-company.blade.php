<div>
    <div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="create-sigle-product" tabindex="-1"
            aria-labelledby="create-sigle-product-lable" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="create-sigle-product-lable">Crear un nuevo producto para
                            {{$company->name}}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Nombre de producto asociado: </label>
                                    <input wire:model="product_name" type="text"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        id="inputAddress" placeholder="" name="product_name">
                                    @error('product_name')
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
    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3">
            <div class="col-12 ">
                <h4 class=" card-title">{{Auth::user()->name}}</h4>
                @role('superadmin')
                <h4>
                    <small class="float-right"><button type="button" class="btn btn-primary btn-sm"
                            data-bs-toggle="modal" data-bs-target="#create-sigle-product">
                            <i class="far fa-plus-square"></i> Nuevo
                            Producto
                        </button>
                    </small>
                </h4>
                @endrole

            </div>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for=""> Fecha de registro: </label> @if (isset($company))
                                {{$company->created_at}}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="form-group">
                    <form wire:submit.prevent="update">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <label for="">Nombre de comercializadora: </label>
                                <input wire:model="company_name" type="text"
                                    class="form-control @error('company_name') is-invalid @enderror" id="inputCity"
                                    name="name">
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 invoice-col">
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
                            <div class=" form-group col-md-3" style="margin-top: 30px">
                                <button type="submit" class="btn btn-success"><i class="far fa-save"></i>
                                    Guardar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>
</div>