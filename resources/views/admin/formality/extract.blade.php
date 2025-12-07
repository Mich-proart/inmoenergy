@extends('adminlte::page')


@section('meta_tags')
<meta name="version" content="{{ config('app.version') }}">
@stop

@section('content_header')
<div class="row">
    <div class="col-md-6 image-text-container">
        @if (isset($program))
        <img src="{{ asset('/vendor/adminlte/dist/img/icons/' . $program->image) }}" alt=""
            class="img-thumbnail align-self-center resize">
        <h3>{{ucfirst($program->name)}}</h3>
        @section('title', ucfirst($program->name))
        @endif
    </div>
</div>
@stop

@section('content')

<div>
    <div>
        <div class="card card-success card-outline">
            <div class="card-body table-responsive p-0">
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="" scope="col">Archivo</th>
                                <th class="text-center" scope="col">Cantidad de registros</th>
                                <th class="text-center" scope="col">Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ucfirst($program->name)}}</td>
                                <td class="text-center">
                                    @isset($count)
                                        {{$count}}
                                    @endisset
                                </td>
                                <td class="text-center">
                                    <button id="xlsxDownload" class="btn btn-success btn-sm" type="button">
                                        archivo .XLSX
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link href="{{ asset('css/' . 'badge.css') }}" rel="stylesheet" />
<link href="{{ asset('css/' . 'icons.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<script src="/vendor/custom/data.handle.js"></script>
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    $(document).ready(async function () {
        let csv = '';
        let excelData = [];
        try {
            const response = await fetch("{{route('admin.formality.fetch.issuer')}}", { method: 'GET', });
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const data = await response.json();
            //csv = handle(data);

            if (data.formality && Array.isArray(data.formality)) {
                // Process the formality array for both CSV and XLSX
                excelData = handleExcel(data.formality);  // Process data for XLSX
            } else {
                console.error("Data structure is not as expected, 'formality' is missing or not an array.");
            }

        } catch (error) {
            console.error('Error fetching data:', error);
        }
        $('#csvDownload').click(function () {
            csvDownload(csv, `extracción_trámites_${Date.now()}`);
        })

        $('#xlsxDownload').click(function () {
            if (excelData.length > 0) {
                downloadExcel(excelData, `extracción_trámites_${Date.now()}.xlsx`);
            } else {
                console.error("No Excel data to download");
            }
        });

        
    });

    function handleExcel(data) {
            if (!data || data.length === 0) {
                console.error("No data available for Excel conversion");
                return [];
            }

            // Map the formality array to Excel format
            return data.map(item => ({
                'Fecha y hora entrada trámite': item['fecha y hora entrada trámite'] || '',
                'Tipo trámite': item['tipo trámite'] || '',
                'Suministro': item['suministro'] || '',
                'Tipo cliente': item['tipo cliente'] || '',
                'Cliente final': item['cliente final'] || '',
                'Email cliente final': item['email cliente final'] || '',
                'Tratamiento cliente final': item['tratamiento cliente final'] || '',
                'Tipo de documento cliente final': item['tipo de documento cliente final'] || '',
                'Número documento cliente final': item['numero documento cliente final'] || '',
                'Teléfono cliente final': item['teléfono cliente final'] || '',
                'IBAN cliente final': item['iban cliente final'] || '',
                'Tipo de calle cliente final': item['tipo de calle cliente final'] || '',
                'Nombre calle cliente final': item['nombre calle cliente final'] || '',
                'Número calle cliente final': item['número calle cliente final'] || '',
                'Bloque cliente final': item['bloque cliente final'] || '',
                'Escalera bloque final': item['escalera bloque final'] || '',
                'Piso cliente final': item['piso cliente final'] || '',
                'Puerta cliente final': item['puerta cliente final'] || '',
                'Código postal cliente final': item['código postal cliente final'] || '',
                'Población cliente final': item['población cliente final'] || '',
                'Provincia cliente final': item['provincia cliente final'] || '',
                'Observaciones del trámite': item['observaciones del trámite'] || '',
                'Estado trámite': item['estado trámite'] || '',
                'Observaciones del tramitador': item['observaciones del tramitador'] || '',
                'Compañía suministro': item['compañía suministro'] || ''
            }));
        }

        function downloadExcel(data, fileName) {
            if (!data || data.length === 0) {
                console.error("No data to write into Excel");
                return;
            }

            const ws = XLSX.utils.json_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Datos');
            XLSX.writeFile(wb, fileName);
        }

</script>
@stop