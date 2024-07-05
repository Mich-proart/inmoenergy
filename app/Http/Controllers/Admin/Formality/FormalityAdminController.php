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
        $formality = $this->formalityService->findByIdDetail($id);

        if ($formality)
            return view('admin.formality.get', ['formality' => $formality]);

    }
    public function modify(int $id)
    {

        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::EN_CURSO->value);
            $data = Formality::where('id', $id)->first();

            if ($data) {

                $prevStatus = $data->formality_status_id;

                $data->update(['formality_status_id' => $status->id]);

                $formality = $this->formalityService->findByIdDetail($id);

                DB::commit();
                return view('admin.formality.modify', ['formality' => $formality, 'prevStatus' => $prevStatus]);
            }


        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }



    }
}
