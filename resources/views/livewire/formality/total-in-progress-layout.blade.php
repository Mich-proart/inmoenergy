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
    <div>
        <div wire:ignore class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Oficina usuario</th>
                            <th>Grupo empresarial</th>
                            <th>Cliente emisor</th>
                            <th>Usuario asignado</th>
                            <th>Fecha de entrada</th>
                            <th>Fecha de asignación</th>
                            <th>Tipo</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>N documento</th>
                            <th>Dirección</th>
                            <th>Estado Trámite</th>
                            <th>Trámite Crítico</th>
                            <th>Tickets pendientes</th>
                            <th>Documentos</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>

    <div>
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
        <script src="/vendor/custom/functions.code.js"></script>
        <script src="/vendor/custom/badge.code.js"></script>
        <script>
            const table = new DataTable('#formality-content', {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: `Consultas de tramites en curso totales - ${new Date()}`
                    }
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{route('api.formality.totalInprogress')}}",
                    "type": "GET"
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "columns": [
                    { data: 'office' },
                    { data: 'business_group' },
                    { data: 'issuer' },
                    { data: 'assigned' },
                    { data: 'created_at' },
                    { data: 'assignment_date' },
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
                    {
                        data: 'formality_id', render: function (data, type, row, meta) {
                            return pendinTicketsSeventeenthProgram(data, "{{route('api.formality.ticket')}}");
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
                    { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14] },
                    { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13] },
                    { className: "target", targets: [0, 1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13] },
                ],
                "order": [
                    [0, "desc"]
                ],
            });

            let queryParams = "from=total";
            let formality_id = 0;
            $('#formality-content').on('click', '.target', function () {
                const row = table.row(this).data();
                formality_id = row.formality_id;
                if (row.status == "en curso") {
                    let url = "{{ route('admin.formality.modify', ':id') }}".replace(':id', formality_id) + "?" + queryParams;
                    window.location.href = url;
                    return;
                }
                Swal.fire({
                    title: "¿Quieres abrir este trámite?",
                    text: "Al abrir iniciará su proceso de tramitación.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "si",
                    cancelButtonText: "no"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('admin.formality.modify', ':id') }}".replace(':id', formality_id) + "?" + queryParams;
                        window.location.href = url;
                    }
                });
            })

        </script>
    </div>
</div>