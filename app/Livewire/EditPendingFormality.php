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

    public $days_to_renew;

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
            $formality = $this->formalityService->getById($this->form->formalityId);


            if ($formality) {
                $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::EN_VIGOR->value);
                $renewal_date = null;

                $this->days_to_renew = $formality->product->company->days_to_renew;

                if ($this->form->isRenewable) {

                    $this->validate(
                        [
                            'days_to_renew' => 'required|integer|between:1,365'
                        ],
                        [
                            'days_to_renew.required' => 'Por favor, Agregue un producto al trámite',
                        ]
                    );

                    $date = $this->form->activation_date;
                    $days = $formality->product->company->days_to_renew;
                    $renewal_date = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
                }

                $updates = array_merge(
                    $this->form->getDataToUpdate(),
                    [
                        'status_id' => $status->id,
                        'renewal_date' => $renewal_date
                    ]
                );
                $formality->update($updates);
            }

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
                ->update([
                    'status_id' => $status->id,
                    'activation_date' => null,
                    'isRenewable' => false,
                    'renewal_date' => null
                ]);
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
                'status_id' => $status->id,
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
