<div>

    <!-- Button trigger modal -->
    <small class="float-right">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#getTicketModel">
            Tickets
        </button>
    </small>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="getTicketModel" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tickets asociados</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th scope="col text-center">
                                    <p class="text-center fs-6">Fecha emisión ticket</p>
                                </th>
                                <th scope="col text-center">
                                    <p class="text-center fs-6">Cliente emisor ticket</p>
                                </th>
                                <th scope="col text-center">
                                    <p class="text-center fs-6">Tipo de ticket</p>
                                </th>
                                <th scope="col text-center">
                                    <p class="text-center fs-6">Título ticket</p>
                                </th>
                                <th scope="col text-center">
                                    <p class="text-center fs-6">Estado ticket</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset ($tickets)
                                @foreach ($tickets as $item)
                                    <tr wire:click="process({{ $item->id }})" data-value="{{ $item->id }}" class="table-light"
                                        style="cursor: pointer;">
                                        <td>
                                            <p class="text-center fs-6">
                                                {{ $item->created_at }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center fs-6">
                                                {{ ucfirst($item->issuer->name . ' ' . $item->issuer->first_last_name . ' ' . $item->issuer->second_last_name) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center fs-6">
                                                {{ $item->type->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center fs-6">
                                                {{ $item->ticket_title }}
                                            </p>
                                        </td>
                                        <td>
                                            @isset ($item->status)
                                                <x-badge.status-simple :status="$item->status" />
                                            @endisset
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                    <div>
                        @if (count($tickets) > 0)
                            {{ $tickets->links('components.pagination') }}
                        @endif
                    </div>
                    <div class="row no-print px-3">
                        <div class="col-12">
                            <div style="margin-top: 10px; margin-bottom: 10px">
                                <button type="button" class="btn float-right btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createNewTicketModal">
                                    Nuevo ticket
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="createNewTicketModal" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-labelledby="createNewTicketModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createNewTicketModalLabel">Nuevo ticket</h1>
                        <button wire:click="resetCreateTicket" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label for="inputZip">Título: </label>
                                <input wire:model="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror" name="title" id="title">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputZip">Tipo: </label>
                                @if (isset($this->types))
                                    @foreach ($this->types as $item)
                                        <div class="form-check form-check-inline">
                                            <input wire:model="ticketTypeId" class="form-check-input" type="radio" id=""
                                                name="ticketTypeId" value="{{ $item->id }}">
                                            <label class="form-check-label" for="">{{ ucfirst($item->name) }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @error('ticketTypeId')
                                <p class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                            <div style="margin-top: 50px; margin-bottom: 25px">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Descripción</label>
                                    <textarea wire:model="description"
                                        class="form-control  @error('description') is-invalid @enderror"
                                        id="exampleFormControlTextarea1" rows="3" name="observation"></textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetCreateTicket" type="button" class="btn btn-secondary"
                            id="createTicketModalClose" data-bs-dismiss="modal">Cerrar</button>
                        <button wire:click="createTicket" type="button" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.table-lightt').click(function () {

                const id = $(this).data('value');

                let url = "{{ route($to, ':id') }}".replace(':id', id);
                url = new URL(url);
                let params = new URLSearchParams(url.search);
                params.set('from', "{{$from}}");
                url.search = params.toString();
                window.location.href = url.toString();
            });
        })
    </script>
    @script
    <script>

        $wire.on('approve', (e) => {
            Swal.fire({
                title: "¿Quieres abrir este ticket?",
                text: "Al abrir iniciará su proceso de resolución.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "si",
                cancelButtonText: "no"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('startProcess');
                }
            });
        });

        $wire.on('notification-created', (e) => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: e.title,
                showConfirmButton: false,
                timer: 1500
            });

            $('#createTicketModalClose').click();
        });

    </script>
    @endscript
</div>