<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="koModal" tabindex="-1" aria-labelledby="koModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Rechazar trámite</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveKo">
                    <div class="modal-body">
                        <p>¿Estas seguro de rechazar el trámite?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancalar</button>
                        <button type="submit" class="btn btn-success float-right">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="resetFormalityModal" tabindex="-1"
        aria-labelledby="resetFormalityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="resetFormalityModalLabel">Volver a tramitar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="resetFormality">
                    <div class="modal-body">
                        <p>¿Estas seguro de volver a tramitar este registro?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancalar</button>
                        <button type="submit" class="btn btn-success float-right">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div wire:ignore class="card-body table-responsive p-0">
                <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario asignado</th>
                            <th>Tipo de tramite</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Dirección</th>
                            <th>Fecha finalización tramite</th>
                            <th>Estado Tramite</th>
                            <th>Compañía Suministro</th>
                            <th>Producto Compañía</th>
                            <th>Consumo anual</th>
                            <th>CUPS</th>
                            <th>Optiones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
        <!-- Button trigger modal -->
        <button type="button" id="edit_renovation_btn" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#editRenovationModal" hidden></button>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="editRenovationModal" tabindex="-1"
            aria-labelledby="editRenovationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editRenovationModalLabel">Asignacion de fecha de activación
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputState">Fecha de activación: </label>
                                    <input wire:model="form.activation_date" type="date"
                                        class="form-control @error('form.activation_date') is-invalid @enderror"
                                        id="inputCity" name="activation_date">
                                    @error('form.activation_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <input id="formalityId" type="text" wire:model="form.formalityId" value=""
                                        class="form-control @error('form.formalityId') is-invalid @enderror" hidden>
                                    @error('form.formalityId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input wire:model="form.isRenewable" class="form-check-input" type="checkbox"
                                            value="0" id="isRenewable">
                                        <label class="form-check-label" for="invalidCheck2">
                                            Renovación
                                        </label>

                                    </div>
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
    <script src="http://127.0.0.1:8000/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        const table = new DataTable('#formality-content', {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.activation.pending')}}",
                "type": "GET",
                "data": {
                    "assignedId": "{{Auth::id()}}",
                    "activation_date_null": true,
                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'created_at' },
                { data: 'assigned' },
                { data: 'type' },
                { data: 'service' },
                { data: 'fullName' },
                { data: 'fullAddress' },
                { data: 'completion_date' },
                { data: 'status' },
                { data: 'company' },
                { data: 'product' },
                { data: 'annual_consumption' },
                { data: 'CUPS' },
                {
                    data: "formality_id", render: function (data, type, row, meta) {
                        return `
                            <button type="button" wire:click="editFormality(${data})" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#resetFormalityModal"><i class="fas fa-edit"></i> Volver a tramitar</button>
                            <button type="button" wire:click="editFormality(${data})" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#koModal"><i class="fas fa-times"></i> K.O</button>
                            <button type="button" id="editFormality${data}" wire:click="editFormality(${data})" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editRenovationModal" data-bs-toggle="modal"
                            data-bs-target="#editRenovationModal" hidden><i class="fas fa-times"></i> </button>
                        `;
                    }
                }
            ],
            "columnDefs": [
                {
                    "render": function (data, type, row) {
                        return `<span class="badge rounded-pill bg-info text-dark">${data}</span>`;
                    },
                    "targets": 7
                },
                { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12] },
                { className: "text-capitalize", targets: [1, 2, 3, 4, 5, 7, 8, 9, 10] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11] },
            ], "order": [
                [0, "desc"]
            ],
        });
        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            $('#formalityId').val(row.formality_id);
            $(`#editFormality${row.formality_id}`).click();
        })
    </script>
</div>