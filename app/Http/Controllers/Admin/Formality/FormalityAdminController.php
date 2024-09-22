<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Formality;
use App\Models\Program;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;

class FormalityAdminController extends Controller
{

    public function __construct(
        private readonly FormalityService $formalityService
    ) {
        $this->middleware('can:formality.create')->only('create');
        $this->middleware('can:formality.inprogress.access')->only('getInProgress', 'edit', 'get');
        $this->middleware('can:formality.closed.access')->only('getClosed', 'get');
        $this->middleware('can:formality.assigned.access')->only('getAssigned', 'modify');
        $this->middleware('can:formality.completed.access')->only('getCompleted', 'viewCompleted');
        $this->middleware('can:formality.pending.access')->only('getPending');
        $this->middleware('can:formality.extract.access')->only('getExtract');
        $this->middleware('can:formality.data.access')->only('getData');
        $this->middleware('can:formality.total.closed.access')->only('getTotalClosed');
        $this->middleware('can:formality.assignment.access')->only('getAssignment');
        $this->middleware('can:formality.totalInProgress.access')->only('getTotalInProgress', 'modify');
    }
    public function create()
    {
        return view('admin.formality.create');
    }

    public function edit(int $id)
    {
        $program = Program::where('name', 'trámites en curso')->first();
        $formality = $this->formalityService->getById($id);

        if (!$formality) {
            return view('admin.error.notFound');
        }

        if ($formality && $formality->canClientEdit == 0) {
            return redirect()->route('admin.formality.get', ['id' => $id]);
        }

        return view('admin.formality.edit', ['formality' => $formality, 'program' => $program]);
    }
    public function get(int $id)
    {
        $formality = $this->formalityService->getById($id);
        if ($formality) {
            $client = $formality->client;
            $address = $formality->address;
            $CorrespondenceAddress = $formality->CorrespondenceAddress;
            return view('admin.formality.get', ['formality' => $formality, 'client' => $client, 'address' => $address, 'CorrespondenceAddress' => $CorrespondenceAddress]);
        } else {
            return view('admin.error.notFound');
        }


    }
    public function viewCompleted(int $id)
    {
        $formality = $this->formalityService->getById($id);
        $client = $formality->client;
        $address = $formality->address;
        $CorrespondenceAddress = $formality->CorrespondenceAddress;

        if ($formality)
            return view('admin.formality.getcompleted', ['formality' => $formality, 'client' => $client, 'address' => $address, 'CorrespondenceAddress' => $CorrespondenceAddress]);

    }
    public function modify(Request $request, $id)
    {

        DB::beginTransaction();
        $from = $request->input('from');


        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::EN_CURSO->value);
            $data = Formality::where('id', $id)->first();

            if ($data) {

                $prevStatus = $data->status_id;

                $data->update(['status_id' => $status->id, 'canClientEdit' => 0]);

                $formality = $this->formalityService->getById($id);
                $client = $formality->client;
                $address = $formality->address;
                $CorrespondenceAddress = $formality->CorrespondenceAddress;

                DB::commit();
                return view('admin.formality.modify', ['formality' => $formality, 'client' => $client, 'address' => $address, 'CorrespondenceAddress' => $CorrespondenceAddress, 'prevStatus' => $prevStatus, 'from' => $from]);
            } else {
                return view('admin.error.notFound');
            }


        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function getInProgress()
    {
        $program = Program::where('name', 'trámites en curso')->first();
        return view('admin.formality.inprogress', ['program' => $program]);
    }
    public function getClosed()
    {
        $program = Program::where('name', 'trámites cerrados')->first();
        return view('admin.formality.closed', ['program' => $program]);
    }
    public function getAssigned()
    {
        $program = Program::where('name', 'trámites asignados')->first();
        return view('admin.formality.assigned', ['program' => $program]);
    }
    public function getCompleted()
    {
        $program = Program::where('name', 'trámites realizados')->first();
        return view('admin.formality.completed', ['program' => $program]);
    }
    public function getPending()
    {
        $program = Program::where('name', 'altas pendientes fecha activación')->first();
        return view('admin.formality.pending', ['program' => $program]);
    }
    public function getAssignment()
    {
        $program = Program::where('name', 'asignación de trámite')->first();
        return view('admin.formality.assignment', ['program' => $program]);
    }
    public function getTotalInProgress()
    {
        $program = Program::where('name', 'trámites en curso totales')->first();
        return view('admin.formality.totalInProgress', ['program' => $program]);
    }

    public function getExtract()
    {
        $program = Program::where('name', 'extracción de trámites')->first();
        return view('admin.formality.extract', ['program' => $program]);
    }

    public function getData()
    {
        $program = Program::where('name', 'datos trámites inmoenergy')->first();
        return view('admin.formality.data', ['program' => $program]);
    }

    public function getTotalClosed()
    {
        $program = Program::where('name', 'trámites cerrados totales')->first();
        return view('admin.formality.totalClosed', ['program' => $program]);
    }
    public function getAssignmentRenovation()
    {
        $program = Program::where('name', 'asignación renovaciones')->first();
        return view('admin.formality.assignmentRenovation', ['program' => $program]);
    }

    public function exportCSV()
    {
        /*
        $filename = 'datos_trámites_inmoenergy.csv';

        $headers = [
            'Content-Encoding' => 'utf-8',
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'código trámite',
            'cliente emisor tramite',
            'fecha y hora entrada tramite',
            'usuario asignado',
            'fecha y hora asignación',
            'tipo tramite',
            'suministro',
            'tipo cliente',
            'cliente final',
            'email cliente final',
            'tratamiento cliente final',
            'tipo de documento cliente final',
            'numero documento cliente final',
            'teléfono cliente final',
            'iban cliente final',
            'tipo de calle cliente final',
            'nombre calle cliente final',
            'número calle cliente final',
            'bloque cliente final',
            'escalera bloque final',
            'piso cliente final',
            'puerta cliente final',
            'código postal cliente final',
            'población cliente final',
            'provincia cliente final',
            'tipo de calle correspondencia cliente final',
            'nombre calle correspondencia cliente final',
            'número calle correspondencia cliente final',
            'bloque cliente correspondencia final',
            'escalera bloque correspondencia final',
            'piso cliente correspondencia final',
            'puerta cliente correspondencia final',
            'código postal correspondencia cliente final',
            'población correspondencia cliente final',
            'provincia correspondencia cliente final',
            'observaciones del tramite',
            'fecha finalización tramite',
            'estado tramite',
            'observaciones del tramitador',
            'tramite critico',
            'compañía suministro',
            'tarifa acceso',
            'producto compañía',
            'consumo anual',
            'cups',
            'observaciones internas',
            'compañía suministro anterior',
            'tipo de vivienda',
            'potencia',
            'comisión bruta',
            'renovación',
            'fecha activación',
            'fecha renovación',
        ]);

        $query = $this->formalityService->getQueryWithAll();

        $query->chunk(25, function ($formalities) use ($handle) {
            foreach ($formalities as $formality) {
                $data = [
                    isset($formality->id) ? $formality->id : '',
                    isset($formality->issuer) ? $formality->issuer->name . ' ' . $formality->issuer->first_last_name . ' ' . $formality->issuer->second_last_name : '',
                    isset($formality->created_at) ? $formality->created_at : '',
                    isset($formality->assigned) ? $formality->assigned->name . ' ' . $formality->assigned->first_last_name . ' ' . $formality->assigned->second_last_name : '',
                    isset($formality->assignment_date) ? $formality->assignment_date : '',
                    isset($formality->type) ? $formality->type->name : '',
                    isset($formality->service) ? $formality->service->name : '',
                    isset($formality->client->clientType) ? $formality->client->clientType->name : '',
                    isset($formality->client) ? $formality->client->name . ' ' . $formality->client->first_last_name . ' ' . $formality->client->second_last_name : '',
                    isset($formality->client) ? $formality->client->email : '',
                    isset($formality->client->clientType) ? $formality->client->clientType->name : '',
                    isset($formality->client->documentType) ? $formality->client->documentType->name : '',
                    isset($formality->client) ? $formality->client->document_number : '',
                    isset($formality->client) ? $formality->client->phone : '',
                    isset($formality) ? $formality->iban : '',
                    isset($formality->address->streetType) ? $formality->address->streetType->name : '',
                    isset($formality->address) ? $formality->address->street_name : '',
                    isset($formality->address) ? $formality->address->street_number : '',
                    isset($formality->address) ? $formality->address->block : '',
                    isset($formality->address) ? $formality->address->block_staircase : '',
                    isset($formality->address) ? $formality->address->floor : '',
                    isset($formality->address) ? $formality->address->door : '',
                    isset($formality->address) ? $formality->address->zip_code : '',
                    isset($formality->address->location) ? $formality->address->location->name : '',
                    isset($formality->address->location->province) ? $formality->address->location->province->name : '',
                    isset($formality->CorrespondenceAddress->streetType) ? $formality->CorrespondenceAddress->streetType->name : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->street_name : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->street_number : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->block : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->block_staircase : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->floor : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->door : '',
                    isset($formality->CorrespondenceAddress) ? $formality->CorrespondenceAddress->zip_code : '',
                    isset($formality->CorrespondenceAddress->location) ? $formality->CorrespondenceAddress->location->name : '',
                    isset($formality->CorrespondenceAddress->location->province) ? $formality->CorrespondenceAddress->location->province->name : '',
                    isset($formality) ? $formality->observation : '',
                    isset($formality) ? $formality->completion_date : '',
                    isset($formality->status) ? $formality->status->name : '',
                    isset($formality) ? $formality->issuer_observation : '',
                    isset($formality) ? $formality->isCritical : '',
                    isset($formality->product->company) ? $formality->product->company->name : '',
                    isset($formality->accessRate) ? $formality->accessRate->name : '',
                    isset($formality->product) ? $formality->product->name : '',
                    isset($formality) ? $formality->annual_consumption : '',
                    isset($formality) ? $formality->CUPS : '',
                    isset($formality) ? $formality->internal_observation : '',
                    isset($formality->previous_company) ? $formality->previous_company->name : '',
                    isset($formality->address->housingType) ? $formality->address->housingType->name : '',
                    isset($formality) ? $formality->potency : '',
                    isset($formality->commission) ? $formality->commission->formatTo('es_ES') : $formality->commission,
                    isset($formality) ? $formality->isRenewable : '',
                    isset($formality) ? $formality->activation_date : '',
                    isset($formality) ? $formality->renewal_date : '',
                ];

                fputcsv($handle, $data);
            }
                
        });

        fclose($handle);

        return Response::make('', 200, $headers);
        */
    }
    public function exportByIssuerCSV()
    {
        /*
        $filename = 'extracción_trámites.csv';

        $userId = auth()->user()->id;

        $headers = [
            'Content-Encoding' => 'utf-8',
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'fecha y hora entrada tramite',
            'tipo tramite',
            'suministro',
            'tipo cliente',
            'cliente final',
            'email cliente final',
            'tratamiento cliente final',
            'tipo de documento cliente final',
            'numero documento cliente final',
            'teléfono cliente final',
            'iban cliente final',
            'tipo de calle cliente final',
            'nombre calle cliente final',
            'número calle cliente final',
            'bloque cliente final',
            'escalera bloque final',
            'piso cliente final',
            'puerta cliente final',
            'código postal cliente final',
            'población cliente final',
            'provincia cliente final',
            'observaciones del tramite',
            'estado tramite',
            'observaciones del tramitador',
            'compañía suministro',
        ]);

        $query = $this->formalityService->getQueryWithAll();

        $query->whereHas('issuer', function ($query) use ($userId) {
            $query->where('id', $userId);
        });

        $query->chunk(25, function ($formalities) use ($handle) {
            foreach ($formalities as $formality) {
                $data = [
                    isset($formality->created_at) ? $formality->created_at : '',
                    isset($formality->type) ? $formality->type->name : '',
                    isset($formality->service) ? $formality->service->name : '',
                    isset($formality->client->clientType) ? $formality->client->clientType->name : '',
                    isset($formality->client) ? $formality->client->name . ' ' . $formality->client->first_last_name . ' ' . $formality->client->second_last_name : '',
                    isset($formality->client) ? $formality->client->email : '',
                    isset($formality->client->clientType) ? $formality->client->clientType->name : '',
                    isset($formality->client->documentType) ? $formality->client->documentType->name : '',
                    isset($formality->client) ? $formality->client->document_number : '',
                    isset($formality->client) ? $formality->client->phone : '',
                    isset($formality) ? $formality->iban : '',
                    isset($formality->address->streetType) ? $formality->address->streetType->name : '',
                    isset($formality->address) ? $formality->address->street_name : '',
                    isset($formality->address) ? $formality->address->street_number : '',
                    isset($formality->address) ? $formality->address->block : '',
                    isset($formality->address) ? $formality->address->block_staircase : '',
                    isset($formality->address) ? $formality->address->floor : '',
                    isset($formality->address) ? $formality->address->door : '',
                    isset($formality->address) ? $formality->address->zip_code : '',
                    isset($formality->address->location) ? $formality->address->location->name : '',
                    isset($formality->address->location->province) ? $formality->address->location->province->name : '',
                    isset($formality) ? $formality->observation : '',
                    isset($formality->status) ? $formality->status->name : '',
                    isset($formality) ? $formality->issuer_observation : '',
                    isset($formality->product->company) ? $formality->product->company->name : '',
                ];

                fputcsv($handle, $data);
            }
        });

        fclose($handle);

        return Response::make('', 200, $headers);
        */
    }

    public function exportExcel()
    {

    }
}
