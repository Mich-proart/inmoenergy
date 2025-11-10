<div>
    <div>
        <div>
            <div class="card card-success card-outline">
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
                                            <x-badge.resolved-ticket-label :isResolved="$ticket->isResolved" />
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <label for="">Suministro tramitado: </label>
                                            @if (isset($ticket->formality->service))
                                                {{ucfirst($ticket->formality->service->name)}}
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
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Cliente emisor ticket: </label>
                                            @if (isset($ticket->issuer))
                                                {{ucfirst($ticket->assigned->name)}}
                                                {{ " " . $ticket->assigned->first_last_name}}
                                                {{ " " . $ticket->assigned->second_last_name}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Cliente final: </label>
                                            @if (isset($ticket->formality->client))
                                                {{ucfirst($ticket->formality->client->name)}}
                                                {{ " " . $ticket->formality->client->first_last_name}}
                                                {{ " " . $ticket->formality->client->second_last_name}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            <label for="">Dirección: </label>
                                            @if (isset($ticket->formality->address))
                                                {{ucfirst($ticket->formality->address->fullAddress())}}
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
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
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