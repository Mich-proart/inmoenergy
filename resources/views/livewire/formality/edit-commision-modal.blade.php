<div>
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
    </div>
    <div>
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">{{Auth::user()->name}}</h3>
            </div>
            <div wire:ignore class="card-body table-responsive p-0">
                <table id="formality-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Cliente final</th>
                            <th>Dirección</th>
                            <th>Fecha de activación</th>
                            <th>Estado trámite</th>
                            <th>Compañía Suministro</th>
                            <th>Producto Compañía</th>
                            <th>CUPS</th>
                            <th>Comisión Bruta</th>
                            <th>Documentos</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
        <!-- Button trigger modal -->
        <button type="button" id="edit_renovation_btn" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#editRenovationModal" hidden></button>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="editRenovationModal" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRenovationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editRenovationModalLabel">Gestión de comisión
                        </h1>
                        <button wire:click="closeClean" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Comisión bruta: </label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-currency-euro" viewBox="0 0 16 16">
                                                <path
                                                    d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936q-.002-.165.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.6 6.6 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z" />
                                            </svg>
                                        </span>
                                        <input wire:model="form.commission" type="text"
                                            class="form-control @error('form.commission') is-invalid @enderror"
                                            id="commission" name="commission">
                                        @error('form.commission')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <input id="formalityId" type="text" wire:model="form.formalityId" value=""
                                        class="form-control @error('form.formalityId') is-invalid @enderror" hidden>
                                    @error('form.formalityId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row no-print">
                                <div class="col-12">
                                    <div style="margin-top: 50px; margin-bottom: 25px">
                                        <div class="">
                                            <button type="submit" class="btn btn-success float-right"><i
                                                    class="far fa-save"></i>
                                                Guardar cambios</button>
                                        </div>
                                    </div>
                                </div>
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
    <script src="/vendor/custom/badge.code.js"></script>

    <script>
        const table = new DataTable('#formality-content', {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: `Gestión de comisiones - ${new Date()}`
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.formality.totalClosed')}}",
                "type": "GET",
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'fullName' },
                { data: 'fullAddress' },
                {
                    data: 'activation_date', render: function (data, type, row, meta) {
                        if (data) {
                            const date = new Date(data);
                            const formattedDate = date.toISOString().split('T')[0];
                            console.log(formattedDate)
                            return formattedDate;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'status', render: function (data, type, row, meta) {
                        return statusColor(data);
                    }
                },
                { data: 'company' },
                { data: 'product' },
                { data: 'CUPS' },
                {
                    data: 'commission', render: function (data, type, row, meta) {
                        // remove float number ex: 56.0000
                        if (data == null) return '';
                        let num = parseFloat(data);

                        if (Number.isInteger(num)) {
                            return num;
                        } else {
                            // Convert float to a string and replace the dot with a comma
                            return num.toFixed(2).replace(/\.?0+$/, '').replace('.', ',');
                        }

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

                { className: "dt-head-center", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
                { className: "text-capitalize", targets: [1, 2, 3, 4, 5, 7, 8] },
                { className: "target", targets: [0, 1, 2, 3, 4, 5, 7, 8] },
            ], "order": [
                [0, "desc"]
            ],
        });
        $('#formality-content').on('click', '.target', function () {
            const row = table.row(this).data();
            console.log(row);
            $('#formalityId').val(row.formality_id);
            $(`#edit_renovation_btn`).click();
            Livewire.dispatch('startEditing', { formality_id: row.formality_id });
            //$(`#editFormality${row.formality_id}`).click();
        })
    </script>
    @script
    <script>

        $(document).ready(function () {
            $("#commission").on("input", function () {
                let val = $(this).val();

                let fmt = val.toString().split(",");

                fmt[0] = fmt[0].replace(/\./g, "");
                fmt[0] = fmt[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                let result = fmt.join(",");

                $(this).val(result);
            });
            $("#commission").keypress(function (event) {
                if ((event.which < 48 || event.which > 57) && event.which !== 44) {
                    event.preventDefault();
                }
            });
        });
        $wire.on('checks', (e) => {
            console.log(e);
            Swal.fire({
                confirmButtonColor: '#004a99',
                icon: "error",
                title: e.title,
                text: e.error,
            });
        });
    </script>
    @endscript
</div>