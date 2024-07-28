<div>
    <!-- Modal -->
    <div wire:ignore class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($files)
                        <div>{{$files->config->name}}</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div wire:ignore class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>

                            <th>Fecha</th>
                            <th>Usuario asignado</th>
                            <th>Tipo</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>N documento</th>
                            <th>Dirección</th>
                            <th>Estado Tramite</th>
                            <th>Observaciones asesor</th>
                            <th>Optiones</th>
                        </tr>
                    </thead>

                </table>
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
                    title: `Tramites en curso ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.index')}}",
                "type": "GET",
                "data": {
                    "issuerId": "{{Auth::id()}}",
                    "exceptStatus": ["tramitado", "en vigor"]
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
                { data: 'documentNumber' },
                { data: 'fullAddress' },
                {
                    data: 'status', render: function (data, type, row, meta) {
                        return statusColor(data);
                    }
                },
                { data: 'assigned_observation' },
                {
                    data: 'formality_id', render: function (data, type, row, meta) {
                        return `<button type="button" wire:click="getFiles(${data})" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-file"></i></button>`
                    }
                },
            ],
            "columnDefs": [
                { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 8] },
                { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
            ],
            "order": [
                [0, "desc"]
            ],
        });

        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            console.log(row);
            window.location.href = "{{ route('admin.formality.edit', ':id') }}".replace(':id', row.formality_id);
        })
    </script>

</div>