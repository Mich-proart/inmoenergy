<div>
    <div>
        <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Archivos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <x-view.files-items :files="$files" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
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
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>N documento</th>
                            <th>CUPS</th>
                            <th>Dirección</th>
                            <th>Compañía Suministro</th>
                            <th>Producto Compañía</th>
                            <th>Consumo anual</th>
                            <th>Potencia</th>
                            <th>Tipo de vivienda</th>
                            <th>Documentos</th>
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
                        <h1 class="modal-title fs-5" id="editRenovationModalLabel">Renovación
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputState">Asignar usuario: </label>
                                    <select wire:model="user_assigned_id"
                                        class="form-control @error('user_assigned_id') is-invalid @enderror"" id="
                                        inputProvince">
                                        <option value="">-- seleccione --</option>
                                        @if ($this->workers->count() > 0)
                                            @foreach ($this->workers as $worker)
                                                <option value="{{ $worker->id }}">
                                                    {{ ucfirst($worker->name) . ' ' . ucfirst($worker->first_last_name) . ' ' . ucfirst($worker->second_last_name) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_assigned_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                            Trámite Crítico
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
    <script src="/vendor/custom/badge.code.js"></script>

    <script>
        const table = new DataTable('#formality-content', {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: `Asignación renovaciones - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.assignment.renovation')}}",
                "type": "GET"
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'service' },
                { data: 'fullName' },
                { data: 'documentNumber' },
                { data: 'CUPS' },
                { data: 'fullAddress' },
                { data: 'company' },
                { data: 'product' },
                {
                    data: 'annual_consumption', render: function (data, type, row, meta) {
                        return formatEnglishToSpanishannual_consumption(data);
                    }
                },
                {
                    data: 'potency', render: function (data, type, row, meta) {
                        return formatEnglishToSpanishPotency(data);
                    }
                },
                { data: 'housing_type' },
                {
                    data: 'formality_id', render: function (data, type, row, meta) {
                        console.log(data)
                        return `<button type="button" wire:click="getFiles(${data})" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-file"></i></button>`
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
                { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11] },
                { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8, 9] },
            ], "order": [
                [1, "desc"]
            ],
        });
        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            $(`#editFormality${row.formality_id}`).click();
        })
    </script>
</div>