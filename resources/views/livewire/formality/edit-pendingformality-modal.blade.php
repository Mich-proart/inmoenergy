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
                            <th>Fecha de entrada</th>
                            <th>Usuario asignado</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Dirección</th>
                            <th>Fecha finalización trámite</th>
                            <th>Estado trámite</th>
                            <th>Compañía Suministro</th>
                            <th>Producto Compañía</th>
                            <th>Consumo anual</th>
                            <th>CUPS</th>
                            <th>Opciones</th>
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
                                    <label for="">Comisión bruta: </label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-currency-euro" viewBox="0 0 16 16">
                                                <path
                                                    d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936q-.002-.165.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.6 6.6 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z" />
                                            </svg>
                                        </span>
                                        <input wire:model="form.commission" type="text"
                                            class="form-control @error('form.commission') is-invalid @enderror"
                                            id="commission" name="commission">
                                        @error('form.commission')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
                                        @error('days_to_renew')
                                            <div class="form-row">
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row no-print">
                                <div class="col-12">
                                    <div style="margin-top: 50px; margin-bottom: 25px">
                                        <div class="">
                                            <button type="button" wire:click="saveKo"
                                                class="btn btn-danger float-left ">K.O.</button>
                                            <button type="submit" class="btn btn-success float-right"><i
                                                    class="far fa-save"></i>
                                                Guardar cambios</button>
                                            <button type="button" class="btn btn-secondary float-right"
                                                style="margin-right: 10px" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
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
                    title: `Altas pendientes fecha de activación - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.activation.pending')}}",
                "type": "GET",
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'created_at' },
                { data: 'assigned' },
                { data: 'service' },
                { data: 'fullName' },
                { data: 'fullAddress' },
                { data: 'completion_date' },
                {
                    data: 'status', render: function (data, type, row, meta) {
                        return statusColor(data);
                    }
                },
                { data: 'company' },
                { data: 'product' },
                { data: 'annual_consumption' },
                { data: 'CUPS' },
                {
                    data: "formality_id", render: function (data, type, row, meta) {
                        return `
                            <button type="button" wire:click="editFormality(${data})" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#resetFormalityModal"><i class="fas fa-edit"></i> Volver a tramitar</button>
                            <button type="button" wire:click="editFormality(${data})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#koModal"><i class="fas fa-times"></i> K.O.</button>
                            <button type="button" id="editFormality${data}" wire:click="editFormality(${data})" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editRenovationModal" data-bs-toggle="modal"
                            data-bs-target="#editRenovationModal" hidden><i class="fas fa-times"></i> </button>
                        `;
                    }
                }
            ],
            "columnDefs": [

                { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11] },
                { className: "text-capitalize", targets: [1, 2, 3, 4, 5, 7, 8, 9] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8, 9, 10] },
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