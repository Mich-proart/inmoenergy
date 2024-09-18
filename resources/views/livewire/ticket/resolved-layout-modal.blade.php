<div>
    <div>
        <div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{Auth::user()->name}}</h3>
                </div>
                <div wire:ignore class="card-body table-responsive p-0">
                    <table id="ticket-content" class="table table-hover text-nowrap" style="cursor:pointer">
                        <thead>
                            <tr>
                                <th>Suministro</th>
                                <th>Cliente final</th>
                                <th>Dirección</th>
                                <th>Fecha emisión ticket</th>
                                <th>Cliente emisor ticket</th>
                                <th>Tipo</th>
                                <th>Título ticket</th>
                                <th>Fecha resolución ticket</th>
                                <th>Resolución ticket</th>
                                <th hidden>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
        <button type="button" id="edit_renovation_btn" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#editRenovationModal" hidden></button>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="editRenovationModal" tabindex="-1"
            aria-labelledby="editRenovationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editRenovationModalLabel"><i class="fas fa-file-invoice"></i>
                            Ticket
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @isset ($ticket)
                            <section>
                                <div class="form-group">
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Fecha de entrada:</label> {{$ticket->created_at}}
                                        </div>
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Fecha resolución ticket:</label>
                                            {{$ticket->resolution_date}}
                                        </div>
                                    </div>
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Título ticket: </label>
                                            {{ucfirst($ticket->ticket_title)}}
                                        </div>
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Resolución ticket:</label>
                                            @if ($ticket->isResolved == 1)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green"
                                                    class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                    <path
                                                        d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                    <path
                                                        d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="grey"
                                                    class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                                    <path
                                                        d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="form-group">
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            <label for="">Tipo de ticket: </label> @if (isset($ticket->type))
                                                {{ucfirst($ticket->type->name)}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div style="margin-top: 50px; margin-bottom: 25px">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Descripción ticket</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        name="observation" @readonly(true)>{{$ticket->ticket_description}}</textarea>
                                </div>

                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <script src="/vendor/jquery/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        <script src="/vendor/custom/ticket.resolve.js"></script>
        <script>
            const table = new DataTable('#ticket-content', {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: `Ticket resueltos - ${new Date()}`
                    }
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{route('api.ticket.resolved.worker')}}",
                    "type": "GET",
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "columns": [
                    { data: 'service' },
                    { data: 'fullName' },
                    { data: 'fullAddress' },
                    { data: 'created_at' },
                    { data: 'issuer' },
                    { data: 'type' },
                    { data: 'ticket_title' },
                    { data: 'resolution_date' },
                    {
                        data: 'isResolved', render: function (data, type, row, meta) {
                            return isResolvedTicket(data);
                        }
                    },
                    {
                        data: "ticket_id", render: function (data, type, row, meta) {
                            return `
                            <button type="button" id="getInfo${data}" wire:click="getInfo(${data})" data-bs-toggle="modal" data-bs-target="#editRenovationModal" data-bs-toggle="modal"
                             hidden><i class="fas fa-times"></i> </button>
                        `;
                        }
                    }

                ],
                "columnDefs": [
                    { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
                    { className: "text-capitalize", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
                    { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8,] },
                ],
                "order": [
                    [3, "desc"]
                ],
            });
            $('#ticket-content').on('click', '.target', function () {
                const row = table.row(this).data();
                $(`#getInfo${row.ticket_id}`).click();
            })
        </script>
    </div>
</div>