<div>
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
                    <table class="table table-sm table-secondary">
                        <thead>
                            <tr>
                                <th scope="col">Concepto</th>
                                <th scope="col">Nombre</th>
                                <th scope="col text-center">Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($files)
                                @foreach ($files as $file)
                                    <tr class="table-light">
                                        <td>{{ ucfirst($file->config->name) }}</td>
                                        <td>{{ $file->filename }}</td>
                                        <td class="text-center">
                                            <a href="{{route('admin.documents.download', $file->id)}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($formality_file)
                                @foreach ($formality_file as $file)
                                    <tr class="table-light">
                                        <td>{{ ucfirst($file->config->name) }}</td>
                                        <td>{{ $file->filename }}</td>
                                        <td class="text-center">
                                            <a href="{{route('admin.documents.download', $file->id)}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                            <th>Fecha de entrada</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>N documento</th>
                            <th>Dirección</th>
                            <th>Estado trámite</th>
                            <th>Compañía Suministro</th>
                            <th>CUPS</th>
                            <th>Renovación</th>
                            <th>Fecha de activación</th>
                            <th>Documentos</th>
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
                    title: `Tramites realizados - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.status')}}",
                "type": "GET",
                "data": {
                    "assignedId": "{{Auth::id()}}",
                    "onlyStatus": ["tramitado", "en vigor"]
                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'created_at' },
                { data: 'service' },
                { data: 'fullName' },
                { data: 'documentNumber' },
                { data: 'fullAddress' },
                {
                    data: 'status', render: function (data, type, row, meta) {
                        return statusColor(data);
                    }
                },
                { data: 'company' },
                { data: 'CUPS' },
                {
                    data: 'isRenewable', render: function (data, type, row, meta) {
                        if (data === 1) {
                            return `<i class="fa fa-check-square" style="font-size:20px;color:green"></i>`;
                        }
                        return ``;
                    }
                },
                {
                    data: 'activation_date', render: function (data, type, row, meta) {
                        if (data) {
                            const date = new Date(data);
                            const formattedDate = date.toISOString().split('T')[0];
                            console.log(formattedDate)
                            return formattedDate;
                        } else {
                            return '';
                        }
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
                { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] },
                { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
            ], "order": [
                [0, "desc"]
            ],
        });
        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            console.log(row);
            window.location.href = "{{ route('admin.formality.get.completed', ':id') }}".replace(':id', row.formality_id);
        })
    </script>
</div>