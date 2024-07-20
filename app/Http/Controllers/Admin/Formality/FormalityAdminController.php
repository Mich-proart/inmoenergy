<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Formality;
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
        return view('admin.formality.edit', ['formalityId' => $id]);
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
    public function modify(int $id)
    {

        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::EN_CURSO->value);
            $data = Formality::where('id', $id)->first();

            if ($data) {

                $prevStatus = $data->status_id;

                $data->update(['status_id' => $status->id]);

                $formality = $this->formalityService->getById($id);
                $client = $formality->client;
                $address = $formality->address;
                $CorrespondenceAddress = $formality->CorrespondenceAddress;

                DB::commit();
                return view('admin.formality.modify', ['formality' => $formality, 'client' => $client, 'address' => $address, 'CorrespondenceAddress' => $CorrespondenceAddress, 'prevStatus' => $prevStatus]);
            }


        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }



    }
}
