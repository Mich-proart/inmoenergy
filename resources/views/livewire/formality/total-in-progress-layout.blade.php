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
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label>Fecha entrada desde:</label>
                        <input type="date" id="date_from" class="form-control filter-input">
                    </div>
                    <div class="col-md-3">
                        <label>Fecha entrada hasta:</label>
                        <input type="date" id="date_to" class="form-control filter-input">
                    </div>
                    <div class="col-md-3">
                        <label>Usuario asignado:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle form-control text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if(empty($selectedUsers))
                                    Todos
                                @elseif($allUsers)
                                    Todos
                                @else
                                    Opciones ({{count($selectedUsers)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allUsers" wire:click="selectAllUsers" type="checkbox"> Todos
                                    </div>
                                </li>
                                @foreach($users as $user)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedUsers" wire:change="isAllCheckUsers"
                                                type="checkbox" value="{{ $user->id }}"> {{ $user->name }}
                                            {{ $user->first_last_name }} {{ $user->second_last_name }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" id="assigned_id" value="{{ json_encode($selectedUsers) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Suministro:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle form-control text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if(empty($selectedServices))
                                    Todos
                                @elseif($allServices)
                                    Todos
                                @else
                                    Opciones ({{count($selectedServices)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allServices" wire:click="selectAllServices" type="checkbox">
                                        Todos
                                    </div>
                                </li>
                                @foreach($services as $service)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedServices" wire:change="isAllCheckServices"
                                                type="checkbox" value="{{ $service->id }}"> {{ $service->name }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" id="service_id" value="{{ json_encode($selectedServices) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Estado trámite:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle form-control text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if(empty($selectedStatuses))
                                    Todos
                                @elseif($allStatuses)
                                    Todos
                                @else
                                    Opciones ({{count($selectedStatuses)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allStatuses" wire:click="selectAllStatuses" type="checkbox">
                                        Todos
                                    </div>
                                </li>
                                @foreach($statuses as $status)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedStatuses" wire:change="isAllCheckStatuses"
                                                type="checkbox" value="{{ $status->id }}"> {{ $status->name }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" id="status_id" value="{{ json_encode($selectedStatuses) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Compañía suministro:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle form-control text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if(empty($selectedCompanies))
                                    Todos
                                @elseif($allCompanies)
                                    Todos
                                @else
                                    Opciones ({{count($selectedCompanies)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allCompanies" wire:click="selectAllCompanies"
                                            type="checkbox"> Todos
                                    </div>
                                </li>
                                @foreach($companies as $company)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedCompanies" wire:change="isAllCheckCompanies"
                                                type="checkbox" value="{{ $company->id }}"> {{ $company->name }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" id="company_id" value="{{ json_encode($selectedCompanies) }}">
                    </div>
                    <div class="col-md-3">
                        <label>CUPS:</label>
                        <input type="text" id="cups" class="form-control filter-input">
                    </div>
                    <div class="col-md-3">
                        <label>Renovación:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle form-control text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if(empty($selectedRenewable))
                                    Todos
                                @elseif($allRenewable)
                                    Todos
                                @else
                                    Opciones ({{count($selectedRenewable)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allRenewable" wire:click="selectAllRenewable"
                                            type="checkbox"> Todos
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model.live="selectedRenewable" wire:change="isAllCheckRenewable"
                                            type="checkbox" value="1"> Si
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model.live="selectedRenewable" wire:change="isAllCheckRenewable"
                                            type="checkbox" value="0"> No
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" id="is_renewable" value="{{ json_encode($selectedRenewable) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Cliente emisor trámite:</label>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle form-control text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if(empty($selectedIssuers))
                                    Todos
                                @elseif($allIssuers)
                                    Todos
                                @else
                                    Opciones ({{count($selectedIssuers)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allIssuers" wire:click="selectAllIssuers" type="checkbox">
                                        Todos
                                    </div>
                                </li>
                                @foreach($issuers as $issuer)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedIssuers" wire:change="isAllCheckIssuers"
                                                type="checkbox" value="{{ $issuer->id }}"> {{ $issuer->name }}
                                            {{ $issuer->first_last_name }} {{ $issuer->second_last_name }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" id="issuer_id" value="{{ json_encode($selectedIssuers) }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="filter-btn" class="btn btn-primary">Filtrar</button>
                        <button id="clear-btn" class="btn btn-secondary ml-2">Limpiar</button>
                    </div>
                </div>
            </div>
            <div wire:ignore class="card-body table-responsive p-0">
                <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Oficina</th>
                            <th>Grupo</th>
                            <th>Emisor trámite</th>
                            <th>Asignado</th>
                            <th>Entrada</th>
                            <th>Asignación</th>
                            <th>Tipo</th>
                            <th>Suministro</th>
                            <th>Cliente final</th>
                            <th>Identificador</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Crítico</th>
                            <th>Tickets</th>
                            <th>Doc</th>
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
                dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
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
                    "type": "GET",
                    "data": function (d) {
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                        d.assigned_id = JSON.parse($('#assigned_id').val() || '[]');
                        d.service_id = JSON.parse($('#service_id').val() || '[]');
                        d.status_id = JSON.parse($('#status_id').val() || '[]');
                        d.company_id = JSON.parse($('#company_id').val() || '[]');
                        d.cups = $('#cups').val();
                        d.is_renewable = JSON.parse($('#is_renewable').val() || '[]');
                        d.issuer_id = JSON.parse($('#issuer_id').val() || '[]');
                    }
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "columns": [
                    { data: 'office' },
                    { data: 'business_group' },
                    { data: 'issuer' },
                    { data: 'assigned' },
                    {
                        data: 'created_at', render: function (data, type, row, meta) {
                            return formatDate(data);
                        }
                    },
                    {
                        data: 'assignment_date', render: function (data, type, row, meta) {
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
                    { className: "text-left", targets: "_all" },
                    { className: "text-capitalize", targets: "_all" },
                    { className: "target", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] },
                ],
                "order": [
                    [0, "desc"]
                ],
            });

            $('#filter-btn').on('click', function () {
                table.draw();
            });

            $('#clear-btn').on('click', function () {
                $('.filter-input').val('');
                table.draw();
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
                    confirmButtonColor: "#368D68",
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