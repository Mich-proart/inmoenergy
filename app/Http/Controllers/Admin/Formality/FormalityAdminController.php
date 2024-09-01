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
        if ($formality && $formality->canClientEdit == 0) {
            return redirect()->route('admin.formality.get', ['id' => $id]);
        }

        return view('admin.formality.edit', ['formalityId' => $id, 'program' => $program]);
    }
    public function get(int $id)
    {
        $formality = $this->formalityService->getById($id);
        $client = $formality->client;
        $address = $formality->address;
        $CorrespondenceAddress = $formality->CorrespondenceAddress;

        if ($formality)
            return view('admin.formality.get', ['formality' => $formality, 'client' => $client, 'address' => $address, 'CorrespondenceAddress' => $CorrespondenceAddress]);

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
        $program = Program::where('name', 'altas pendientes fecha de activación')->first();
        return view('admin.formality.pending', ['program' => $program]);
    }
    public function getAssignment()
    {
        $program = Program::where('name', 'asignación de trámites')->first();
        return view('admin.formality.assignment', ['program' => $program]);
    }
    public function getTotalInProgress()
    {
        $program = Program::where('name', 'trámites en curso totales')->first();
        return view('admin.formality.totalInProgress', ['program' => $program]);
    }
}
