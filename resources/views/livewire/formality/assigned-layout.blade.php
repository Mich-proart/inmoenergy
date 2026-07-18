<div>
    <link href="{{ asset('css/' . 'truncate.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom-focus.css') }}" rel="stylesheet">
    <!-- Modal -->
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

                    <!-- Edit/upload files section -->
                    <div class="mt-3">
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input" id="editFilesToggle" wire:model.live="showEditFiles">
                            <label class="form-check-label" for="editFilesToggle">Editar archivos existentes</label>
                        </div>

                        @if($showEditFiles)
                            <div class="border p-3 rounded bg-light">
                                @if(session()->has('file_upload_success'))
                                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                                        {{ session('file_upload_success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <!-- Factura Section -->
                                @if($invoiceConfig)
                                    <div class="form-group mb-3">
                                        <label class="form-label font-weight-bold">
                                            {{ ucfirst($invoiceConfig->name) }}:
                                            @if($hasFactura)
                                                <span class="text-success small"><i class="fas fa-check-circle mr-1"></i>(Ya existe un archivo subido)</span>
                                            @else
                                                <span class="text-muted small"><i class="fas fa-exclamation-circle mr-1"></i>(No subido)</span>
                                            @endif
                                        </label>
                                        <input type="file" wire:model="facturaFile" class="form-control">
                                        @error('facturaFile') <span class="text-danger small">{{ $message }}</span> @enderror
                                        <div wire:loading wire:target="facturaFile" class="text-muted small mt-1">
                                            <i class="fas fa-spinner fa-spin mr-1"></i>Subiendo archivo...
                                        </div>
                                    </div>
                                @endif

                                <!-- Contrato Section -->
                                @if($contractConfig)
                                    <div class="form-group mb-3">
                                        <label class="form-label font-weight-bold">
                                            {{ ucfirst($contractConfig->name) }}:
                                            @if($hasContrato)
                                                <span class="text-success small"><i class="fas fa-check-circle mr-1"></i>(Ya existe un archivo subido)</span>
                                            @else
                                                <span class="text-muted small"><i class="fas fa-exclamation-circle mr-1"></i>(No subido)</span>
                                            @endif
                                        </label>
                                        <input type="file" wire:model="contratoFile" class="form-control">
                                        @error('contratoFile') <span class="text-danger small">{{ $message }}</span> @enderror
                                        <div wire:loading wire:target="contratoFile" class="text-muted small mt-1">
                                            <i class="fas fa-spinner fa-spin mr-1"></i>Subiendo archivo...
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-end mt-2">
                                    <button type="button" wire:click="uploadFormalityFiles" class="btn btn-success btn-sm">
                                        <i class="fas fa-save mr-1"></i> Guardar Archivos
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div>
            <div wire:ignore class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{Auth::user()->name}}</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                        <thead>
                            <tr>
                                <th>Entrada</th>
                                <th>Tipo</th>
                                <th>Suministro</th>
                                <th>Cliente final</th>
                                <th>Identificador</th>
                                <th>Dirección</th>
                                <th>Estado</th>
                                <th>Crítico</th>
                                <th>Comercializadora</th>
                                <th>Producto</th>
                                <th>Observaciones asesor</th>
                                <th>Tickets</th>
                                <th>Doc</th>
                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>

        <script src="/vendor/jquery/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
        <script src="/vendor/custom/functions.code.js"></script>
        <script>
            const table = new DataTable('#formality-content', {
                dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: `Tramites asignados - ${new Date()}`
                    }
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{route('api.formality.assigned')}}",
                    "type": "GET",
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "columns": [
                    {
                        data: 'created_at', render: function (data, type, row, meta) {
                            return formatDate(data);
                        }
                    },
                    { data: 'type' },
                    { data: 'service' },
                    { data: 'fullName' },
                    { data: 'documentNumber' },
                    { data: 'fullAddress' },
                    {
                        data: 'status', render: function (data, type, row, meta) {
                            return statusColor(data);
                        }
                    },
                    {
                        data: 'isCritical', render: function (data, type, row, meta) {
                            return criticalCode(data);
                        }
                    },
                    { data: 'company' },
                    { data: 'product' },
                    { data: 'assigned_observation' },
                    {
                        data: 'formality_id', render: function (data, type, row, meta) {
                            return pendinTicketsSeventhProgram(data, "{{route('api.formality.ticket')}}");
                        }
                    },
                    {
                        data: 'formality_id', render: function (data, type, row, meta) {
                            console.log(data)
                            return `<button type="button" wire:click="getFiles(${data})" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-file"></i></button>`
                        }
                    },
                ],
                "columnDefs": [
                    { className: "text-left", targets: "_all" },
                    // { className: "text-capitalize", targets: "_all" },
                    { className: "target", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
                    {
                        targets: 10, // observation index
                        render: function (data, type, row, meta) {
                            if (!data) return '';
                            return `<span class="truncate-text" title="${data}">${data}</span>`;
                        }
                    }
                ],
                "order": [
                    [0, "desc"]
                ],
            });

            let formality_id = 0;
            $('#formality-content').on('click', '.target', function () {
                const row = table.row(this).data();
                formality_id = row.formality_id;
                if (row.status == "en curso") {
                    window.location.href = "{{ route('admin.formality.modify', ':id') }}".replace(':id', formality_id);
                    return;
                }
                Swal.fire({
                    title: "¿Quieres abrir este trámite?",
                    text: "Al abrir iniciará su proceso de tramitación.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#368D68",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "si",
                    cancelButtonText: "no"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.formality.modify', ':id') }}".replace(':id', formality_id);
                    }
                });
            })
        </script>
    </div>
</div>