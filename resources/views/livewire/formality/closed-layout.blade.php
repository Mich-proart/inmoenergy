<div>
    <link href="{{ asset('css/' . 'truncate.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom-focus.css') }}" rel="stylesheet">
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
                            <th>Usuario asignado</th>
                            <th>Tipo</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Identificador</th>
                            <th>Dirección</th>
                            <th>Finalizado</th>
                            <th>Estado</th>
                            <th>Comercializadora</th>
                            <th>Observaciones asesor</th>
                            <th>Doc</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
        <!-- Button trigger modal -->
        <button id="openModal" type="button" hidden class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            Launch static backdrop modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Trámite</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (isset($formality) && !empty($formality))
                            <x-view.formality-body :formality="$formality" :from="'closed'" />
                        @endif
                    </div>
                    <div class="modal-footer">

                    </div>
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
    <script src="/vendor/custom/functions.code.js"></script>
    <script>
        const table = new DataTable('#formality-content', {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: `Tramites cerrados - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.closed')}}",
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
                { data: 'assigned' },
                { data: 'type' },
                { data: 'service' },
                { data: 'fullName' },
                { data: 'documentNumber' },
                { data: 'fullAddress' },
                {
                    data: 'completion_date', render: function (data, type, row, meta) {
                        return formatDate(data);
                    }
                },
                {
                    data: 'status', render: function (data, type, row, meta) {
                        return statusColor(data);
                    }
                },
                { data: 'company' },
                { data: 'assigned_observation' },
                {
                    data: 'formality_id', render: function (data, type, row, meta) {
                        console.log(data)
                        return `<button type="button" wire:click="getFiles(${data})" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-file"></i></button>`
                    }
                },
            ],
            "columnDefs": [
                { className: "text-left", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
                { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 6, 8, 9, 10] },
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
    </script>
    @script
    <script>
        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            console.log(row);
            // window.location.href = " {{-- {{ route('admin.formality.get', ':id') }} --}}".replace(':id', row.formality_id);
            $wire.dispatch('getFormality', {
                id: row.formality_id
            });
        })

        $wire.on('view-formality', (e) => {
            $('#openModal').click();
        });
    </script>
    @endscript
</div>