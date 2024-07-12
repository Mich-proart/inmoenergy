<div>
    <div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div wire:ignore class="card-body table-responsive p-0">
                <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Client emisor</th>
                            <th>Fecha</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Tipo documento</th>
                            <th>N documento</th>
                            <th>Dirección</th>
                            <th>Observaciones del tramite</th>
                            <th>Estado Tramite</th>
                            <th>Tramite Critico</th>
                            <th hidden>Optiones</th>
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
                        <h1 class="modal-title fs-5" id="editRenovationModalLabel">Asignación de usuario
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputState">Asignar usuario: </label>
                                    <select wire:model="user_Assigned_id" class="form-control" id="inputProvince">
                                        <option value="">-- seleccione --</option>
                                        @foreach ($this->workers as $worker)
                                            <option value="{{ $worker->id }}">
                                                {{ $worker->name . ' ' . $worker->first_last_name . ' ' . $worker->second_last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input id="formalityId" type="text" wire:model="formalityId" value=""
                                        class="form-control @error('formalityId') is-invalid @enderror" hidden>
                                    @error('formalityId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input wire:model="isCritical" class="form-check-input" type="checkbox"
                                            value="0" id="isCritical">
                                        <label class="form-check-label" for="invalidCheck2">
                                            Tramite Critico
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

                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'issuer' },
                { data: 'created_at' },
                { data: 'service' },
                { data: 'fullName' },
                { data: 'document_type' },
                { data: 'documentNumber' },
                { data: 'fullAddress' },
                { data: 'observation' },
                { data: 'status' },
                {
                    data: 'isCritical', render: function (data, type, row, meta) {
                        if (data == 0) {
                            return `<div><i class="fas fa-times"></i></div>`;
                        } else {
                            return `<div><i class="fas fa-check"></i></div>`
                        }
                    }
                },
                {
                    data: "formality_id", render: function (data, type, row, meta) {
                        return `
                            <button type="button" id="editFormality${data}" wire:click="editFormality(${data})" data-bs-toggle="modal" data-bs-target="#editRenovationModal" data-bs-toggle="modal"
                             hidden><i class="fas fa-times"></i> </button>
                        `;
                    }
                }
            ],
            "columnDefs": [
                {
                    "render": function (data, type, row) {
                        return `<span class="badge rounded-pill bg-info text-dark">${data}</span>`;
                    },
                    "targets": 8
                },
                { className: "dt-head-center", targets: [0] },
                { className: "text-capitalize", targets: [1, 2, 3, 4, 5, 7, 8, 9, 10] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
            ], "order": [
                [0, "desc"]
            ],
        });
        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            $(`#editFormality${row.formality_id}`).click();
        })
    </script>
</div>