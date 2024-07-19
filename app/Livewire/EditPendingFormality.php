<?php

namespace App\Livewire;

use App\Domain\Enums\FormalityStatusEnum;
use App\Livewire\Forms\editPendingFormalityFields;
use App\Models\Formality;
use Livewire\Component;
use App\Exceptions\CustomException;
use DB;
use App\Domain\Formality\Services\FormalityService;
use Illuminate\Support\Facades\App;

class EditPendingFormality extends Component
{
    protected $formalityService;

    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
    }
    public editPendingFormalityFields $form;
    public function render()
    {
        return view('livewire.edit-pending-formality');
    }

    public function save()
    {
        $this->form->validate();

        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::EN_VIGOR->value);
            $renewal_date = null;

            if ($this->form->isRenewable) {
                $date = $this->form->activation_date;
                $renewal_date = date('Y-m-d', strtotime($date . ' +12 months'));
            }

            $updates = array_merge(
                $this->form->getDataToUpdate(),
                [
                    'status_id' => $status->id,
                    'renewal_date' => $renewal_date
                ]
            );

            Formality::firstWhere('id', $this->form->formalityId)->update($updates);
            DB::commit();
            return redirect()->route('admin.formality.pending');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function editFormality($formalityId)
    {
        $this->form->setId($formalityId);
    }

    public function saveKo()
    {
        $this->form->validateOnly('formalityId');

        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::KO->value);

            Formality::firstWhere('id', $this->form->formalityId)
                ->update(['formality_status_id' => $status->id]);
            DB::commit();
            return redirect()->route('admin.formality.pending');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
    public function resetFormality()
    {
        $this->form->validateOnly('formalityId');

        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::EN_CURSO->value);

            $updates = [
                'formality_status_id' => $status->id,
                'product_id' => null
            ];

            Formality::firstWhere('id', $this->form->formalityId)->update($updates);
            DB::commit();
            return redirect()->route('admin.formality.pending');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
}
