<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row no-print">
                <div class="col-12">
                    <div>
                        <h3 class="card-title">{{Auth::user()->name}}</h3>
                        @role('superadmin')
                        <button wire:click="resetVar" type="button" id="edit_renovation_btn"
                            class="btn btn-primary float-right btn-sm" data-bs-toggle="modal"
                            data-bs-target="#create-product-modal"><i class="far fa-plus-square"></i> Agregar
                            producto</button>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore class="card-body table-responsive p-0">
            <table id="product-content" class="table table-hover text-nowrap" style="cursor:pointer">
                <thead>
                    <tr>
                        <th>Fecha de registro</th>
                        <th>Nombre</th>
                        <th>Comercializadoras</th>
                        <th hidden>Optiones</th>
                    </tr>
                </thead>

            </table>
        </div>
        <div>

            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="create-product-modal" tabindex="-1"
                aria-labelledby="create-product-modal-Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="create-product-modal-Label">Producto
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form wire:submit.prevent="save">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputAddress">Comercializadora: </label>
                                        <select wire:model="companyId"
                                            class="form-control @error('companyId') is-invalid @enderror"
                                            name="companyId" required>
                                            <option value="">-- selecione --</option>
                                            @if (isset($companies))
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ ucfirst($company->name) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('companyId')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputAddress">Nombre del producto: </label>
                                        <input id="name" type="text" wire:model="name" value=""
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success float-right"><i
                                            class="far fa-save"></i>
                                        Guardar cambios</button>
                                </div>
                        </form>
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

    <script>
        const table = new DataTable('#product-content', {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: `Gestión de productos - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.product.query')}}",
                "type": "GET",
                "data": {
                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'created_at' },
                { data: 'product_name' },
                { data: 'company_name' },
                {
                    data: "product_id", render: function (data, type, row, meta) {
                        return `
                             <button id="edit${data}" wire:click="setProduct(${data})" type="button" class="btn btn-primary float-right"
                            data-bs-toggle="modal" data-bs-target="#create-product-modal" hidden><i
                                class="far fa-edit"></i></button>
                        `;
                    }
                }

            ],
            "columnDefs": [
                { className: "dt-head-center", targets: [0, 1, 2] },
                { className: "text-capitalize", targets: [0, 1, 2] },
                { className: "target", targets: [0, 1, 2] }
            ],
            "order": [
                [0, "desc"]
            ],
        });


        $('#product-content').on('click', '.target', function () {
            const row = table.row(this).data();
            $(`#edit${row.product_id}`).click();
        })

    </script>
</div>