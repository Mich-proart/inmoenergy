<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\Formality\Services\FormatFormalityService;
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
        $this->middleware('auth');
        $this->middleware('can:formality.create')->only('create', 'createClient');
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
    public function createClient()
    {
        return view('admin.formality.createClient');
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
    public function modifyTotalClosed(Request $request, $id)
    {
        $from = $request->input('from');

        $formality = $this->formalityService->getById($id);

        if ($formality) {

            $client = $formality->client;
            $address = $formality->address;
            $CorrespondenceAddress = $formality->CorrespondenceAddress;

            return view('admin.formality.modify', ['formality' => $formality, 'client' => $client, 'address' => $address, 'CorrespondenceAddress' => $CorrespondenceAddress, 'from' => $from]);
        } else {
            return view('admin.error.notFound');
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

        $query = $this->formalityService->getQueryWithAll();
        $userId = auth()->user()->id;
        $query->whereHas('issuer', function ($query) use ($userId) {
            $query->where('id', $userId);
        });
        $count = $query->count();

        return view('admin.formality.extract', ['program' => $program, 'count' => $count]);
    }

    public function getData()
    {
        $program = Program::where('name', 'datos trámites inmoenergy')->first();
        $count = $this->formalityService->getQueryWithAll()->count();
        return view('admin.formality.data', ['program' => $program, 'count' => $count]);
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

    public function fetch()
    {
        $data = $this->formalityService->getQueryWithAll()->get();

        $count = $this->formalityService->getQueryWithAll()->count();

        $collection = FormatFormalityService::toArrayAll($data);

        return Response::json(['formality' => $collection, 'count' => $count], 200);
    }
    public function fetchByIssuer()
    {
        $userId = auth()->user()->id;
        $query = $this->formalityService->getQueryWithAll();

        $query->whereHas('issuer', function ($query) use ($userId) {
            $query->where('id', $userId);
        });


        $data = $query->get();
        $count = $query->count();

        $collection = FormatFormalityService::toArrayByIssuer($data);

        return Response::json(['formality' => $collection, 'count' => $count], 200);
    }



    public function exportExcel()
    {

    }
}
