@extends('adminlte::page')

@section('title', 'Comercializadoras')

@section('content_header')
<h1>Comercializadoras</h1>
@stop

@section('content')

<livewire:config.edit-company :company="$company">
    <div>
        <div class="card card-success card-outline">
            <div class="card-header">
                <section>
                    <div class="form-group">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <label for=""> Productos asociados: </label>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="product-content" class="table table-hover text-nowrap" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th>Fecha de registro</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>


    @stop

    @section('css')
    {{-- Add here extra stylesheets --}}
    {{--
    <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    @stop

    @section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        const table = new DataTable('#product-content', {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('api.product.query')}}",
                "type": "GET",
                "data": {
                    "companyId": "{{$company->id}}"
                }
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "columns": [
                { data: 'created_at' },
                { data: 'product_name' },

            ],
            "columnDefs": [
                { className: "dt-head-center", targets: [0, 1] },
                { className: "text-capitalize", targets: [0, 1] }
            ],
            "order": [
                [0, "desc"]
            ],
        });


        $('#user-content').on('click', 'tbody tr', function () {
            const row = table.row(this).data();
            console.log(row);

        })


    </script>
    <script>
        function addQueryParam() {
            var url = new URL('{{ route('admin.users.create') }}');
            var params = new URLSearchParams(url.search);
            params.set('content', 'client');
            url.search = params.toString();
            window.location.href = url.toString();
        }

    </script>
    @stop