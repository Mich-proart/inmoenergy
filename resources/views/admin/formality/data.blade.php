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
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/custom/data.handle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(async function () {
        let csv = '';
        let excelData = [];
        try {
            const response = await fetch("{{route('admin.formality.fetch')}}", { method: 'GET', });
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
            csvDownload(csv, 'datos_trámites_lenders_consulting');
        })
        $('#xlsxDownload').click(function () {
            if (excelData.length > 0) {
                downloadExcel(excelData, `datos_trámites_lenders_consulting_${Date.now()}.xlsx`);
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
                'Código trámite': item['código trámite'] || '',
                'Cliente emisor trámite': item['cliente emisor trámite'] || '',
                'Fecha y hora entrada trámite': item['fecha y hora entrada trámite'] || '',
                'Usuario asignado': item['usuario asignado'] || '',
                'Fecha y hora asignación': item['fecha y hora asignación'] || '',
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
                'Tipo de calle correspondencia cliente final': item['tipo de calle correspondencia cliente final'] || '',
                'Nombre calle correspondencia cliente final': item['nombre calle correspondencia cliente final'] || '',
                'Número calle correspondencia cliente final': item['número calle correspondencia cliente final'] || '',
                'Bloque cliente correspondencia final': item['bloque cliente correspondencia final'] || '',
                'Escalera bloque correspondencia final': item['escalera bloque correspondencia final'] || '',
                'Piso cliente correspondencia final': item['piso cliente correspondencia final'] || '',
                'Puerta cliente correspondencia final': item['puerta cliente correspondencia final'] || '',
                'Código postal correspondencia cliente final': item['código postal correspondencia cliente final'] || '',
                'Población correspondencia cliente final': item['población correspondencia cliente final'] || '',
                'Provincia correspondencia cliente final': item['provincia correspondencia cliente final'] || '',
                'Observaciones del trámite': item['observaciones del trámite'] || '',
                'Fecha finalización trámite': item['fecha finalización trámite'] || '',
                'Estado trámite': item['estado trámite'] || '',
                'Observaciones del tramitador': item['observaciones del tramitador'] || '',
                'Trámite crítico': item['trámite critico'] || '',
                'Compañía suministro': item['compañía suministro'] || '',
                'Tarifa acceso': item['tarifa acceso'] || '',
                'Producto compañía': item['producto compañía'] || '',
                'Consumo anual': item['consumo anual'] || '',
                'CUPS': item['CUPS'] || '',
                'Observaciones internas': item['observaciones internas'] || '',
                'Compañía suministro anterior': item['compañía suministro anterior'] || '',
                'Tipo de vivienda': item['tipo de vivienda'] || '',
                'Potencia': item['potencia'] || '',
                'Comisión bruta': item['comisión bruta'] || '',
                'Renovación': item['renovación'] || '',
                'Fecha activación': item['fecha activación'] || '',
                'Fecha renovación': item['fecha renovación'] || '',
                'Renovado': item['renovado'] || '',
                'Fecha finalización': item['fecha finalización'] || '',
                'Motivo de baja': item['motivo de baja'] || '',
                'Observaciones de baja': item['observaciones de baja'] || ''
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