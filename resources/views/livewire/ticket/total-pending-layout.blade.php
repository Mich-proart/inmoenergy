<div>
    <div>
        <div wire:ignore class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="ticket-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Responsable</th>
                            <th>Oficina</th>
                            <th>Grupo</th>
                            <th>Emisor trámite</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Dirección</th>
                            <th>Emisión</th>
                            <th>Emisor</th>
                            <th>Tipo</th>
                            <th>Ticket</th>
                            <th>Estado</th>
                            <th>Asignado</th>
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
    <script src="/vendor/custom/functions.code.js"></script>
    @script
    <script>
        const table = new DataTable('#ticket-content', {
            dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: `Ticket pendientes totales - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.ticket.total.pending')}}",
                "type": "GET",
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'issuer_formality_responsible_name' },
                { data: 'office' },
                { data: 'business_group' },
                { data: 'issuer_formality' },
                { data: 'service' },
                { data: 'fullName' },
                { data: 'fullAddress' },
                { 
                    data: 'created_at', render: function (data, type, row, meta) {
                        return formatDate(data);
                    } 
                },
                { data: 'issuer' },
                { data: 'type' },
                { data: 'ticket_title' },
                {
                    data: 'status', render: function (data, type, row, meta) {
                        return statusColor(data);
                    }
                },
                { data: 'assigned' },

            ],
            "columnDefs": [
                { className: "text-left", targets: "_all" },
                // { className: "text-capitalize", targets: "_all" }
                ],
            "order": [
                [7, "desc"]
            ],
        });

        $('#ticket-content').on('click', 'tbody tr', function () {
            const row = table.row(this).data();
            $wire.dispatch('process', { id: row.ticket_id });
        })

        $wire.on('approve', (e) => {
            Swal.fire({
                title: "¿Quieres abrir este ticket?",
                text: "Al abrir iniciará su proceso de resolución.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#368D68",
                cancelButtonColor: "#d33",
                confirmButtonText: "si",
                cancelButtonText: "no"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('startProcess');
                }
            });
        });

    </script>
    @endscript
</div>