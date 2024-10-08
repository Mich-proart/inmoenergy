<div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{Auth::user()->name}}</h3>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <label for="">Nombre de desplegable: </label> @if (isset($component))
                                {{ ucfirst($component->name) }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="card card-primary card-outline">

        <div class="mt-3 mr-3">
            <div class="col-12 ">
                @role('superadmin')
                <h4>
                    <small class="float-right"><button wire:click="resetName" type="button"
                            class="btn btn-primary float-right btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg> Crear opción</button>
                    </small>
                </h4>
                @endrole

            </div>
        </div>


        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col text-center">
                        <p class="text-center fs-6">Nombre de opciones</p>
                    </th>
                    <th scope="col text-center">
                        <p class="text-center fs-6">Estado</p>
                    </th>
                    <th scope="col text-center">
                        <p class="text-center fs-6">Opciones</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @isset ($options)
                    @foreach ($options as $option)
                        <tr class="table-light">
                            <td class="text-center">{{ ucfirst($option->name) }}</td>
                            <td class="text-center">
                                @if ($option->is_available)
                                    <span class="custom-badge operative">activo</span>
                                @else
                                    <span class="custom-badge ko">deshabilitado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <div class="form-check form-switch">
                                            <input wire:change="changeAvailability({{ $option->id }})" class="form-check-input"
                                                type="checkbox" role="switch" id="flexSwitchCheckChecked_{{ $option->id }}"
                                                @checked($option->is_available)>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" wire:click="editoption({{ $option->id }})"
                                            class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            <i class="fas fa-pencil-alt"></i> editar</button>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div>
            @if (count($options) > 0)
                {{ $options->links('components.pagination') }}
            @endif
        </div>
    </div>
    <div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> {{ucfirst($component->name)}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Nuevo option: </label>
                                    <input wire:model="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" id="inputAddress"
                                        placeholder="" name="name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success float-right"><i class="far fa-save"></i>
                                Guardar</button>
                        </div>
                    </form>
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
</div>