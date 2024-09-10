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
        $filename = 'extraccion_tramites.csv';

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
        ]);

        $formalities = $this->formalityService->getAll();

        foreach ($formalities as $formality) {
            fputcsv($handle, [
                $formality->id,
                $formality->issuer->name . '' . $formality->issuer->first_last_name . ' ' . $formality->issuer->second_last_name,
                $formality->created_at,
                $formality->assigned ? $formality->assigned->name . ' ' . $formality->assigned->first_last_name . ' ' . $formality->assigned->second_last_name : '',
                $formality->assignment_date,
                $formality->type->name,
                $formality->service->name,
                $formality->client->clientType->name,
                $formality->client->name . ' ' . $formality->client->first_last_name . ' ' . $formality->client->second_last_name,
                $formality->client->email,
                $formality->client->clientType->name,
                $formality->client->documentType->name,
                $formality->client->document_number,
                $formality->client->phone,
                $formality->client->iban,
                $formality->address->streetType->name,
                $formality->address->street_name,
                $formality->address->street_number,
                $formality->address->block,
                $formality->address->floor,
                $formality->address->door,
                $formality->address->zip_code,
                $formality->address->location->name,
                $formality->address->location->province->name,
                $formality->CorrespondenceAddress->streetType->name,
                $formality->CorrespondenceAddress->street_name,
                $formality->CorrespondenceAddress->street_number,
                $formality->CorrespondenceAddress->block,
                $formality->CorrespondenceAddress->floor,
                $formality->CorrespondenceAddress->door,
                $formality->CorrespondenceAddress->zip_code,
                $formality->CorrespondenceAddress->location->name,
                $formality->CorrespondenceAddress->location->province->name,

            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }

    public function exportExcel()
    {

    }
}
