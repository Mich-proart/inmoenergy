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
                </div>
            </div>
        </div>
    </div>

    <button hidden id="warningModalBtn" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
        data-bs-target="#warningModal">
        warningModal
    </button>
    <div wire:ignore.self class="modal fade" id="warningModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="warningModalLabel">¿Quieres abrir este ticket? Al abrir iniciará
                        su proceso de resolución.</h1>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#getTicketModel">No</button>
                    <button type="button" class="btn btn-primary" wire:click="startProcess">Si</button>
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

            $('#warningModalBtn').click();
        });
    </script>
    @endscript
</div>