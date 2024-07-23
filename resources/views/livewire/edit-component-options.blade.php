<div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{Auth::user()->name}}</h3>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Nombre de desplegable: </label> @if (isset($component))
                                {{ ucfirst($component->name) }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div wire:ignore class="card card-primary card-outline">

        <div class="mt-3 mr-3">
            <div class="col-12 ">
                @role('superadmin')
                <h4>
                    <small class="float-right"><button wire:click="resetName" type="button"
                            class="btn btn-primary float-right btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="far fa-plus-square"></i> Crear opción</button>
                    </small>
                </h4>
                @endrole

            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table id="options-content" class="table table-hover text-nowrap" style="cursor:pointer">
                <thead>
                    <tr>
                        <th>Nombre de opciones</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
    <div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> {{ucfirst($component->name)}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Nuevo option: </label>
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
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script>
        const table = new DataTable('#options-content', {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.component.options.query')}}",
                "type": "GET",
                "data": {
                    "componentId": {{$component->id}}
                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'name' },
                {
                    data: "id", render: function (data, type, row, meta) {
                        return `
                            <button type="button" wire:click="editoption(${data})" class="btn btn-primary float-right btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-edit"></i></button>
                        `;
                    }
                }

            ],
            "columnDefs": [
                { className: "dt-head-center", targets: [0, 1] },
                { className: "text-capitalize", targets: [0, 1] }
            ],
            "order": [
                [0, "desc"]
            ],
        });

    </script>

</div>