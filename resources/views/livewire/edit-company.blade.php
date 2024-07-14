<div>
    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3">
            <div class="col-12 ">
                <h4 class=" card-title">{{Auth::user()->name}}</h4>
                @role('superadmin')
                <h4>
                    <small class="float-right"><button class="btn btn-primary btn-sm">Nuevo
                            Producto</button></small>
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