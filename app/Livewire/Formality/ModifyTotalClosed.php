<?php

namespace App\Livewire\Formality;

use App\Domain\Formality\Services\FormalityService;
use App\Livewire\Forms\Formality\FormalityModifyTotalClosed;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use App\Exceptions\CustomException;
use DB;
use App\Domain\Enums\ServiceEnum;

class ModifyTotalClosed extends Component
{
    public FormalityModifyTotalClosed $form;
    public $formality;

    protected $formalityService;


    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
    }

    public function mount($formality)
    {
        $this->formality = $formality;
        $this->form->setData($this->formality);
    }

    public function setContractCompletionDate()
    {
        $date = $this->form->activation_date;
        $this->form->contract_completion_date = date('Y-m-d', strtotime($date . ' +1 year'));

        if ($this->form->isRenewable) {
            $days = $this->formality->product->company->days_to_renew;
            $this->form->renewal_date = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
        } else {
            $this->form->renewal_date = null;
        }

    }

    public function setIsRenewable()
    {

        if (!$this->form->isRenewable) {
            $this->form->renewal_date = null;
        } else {
            $date = $this->form->activation_date;
            $days = $this->formality->product->company->days_to_renew;
            $this->form->renewal_date = date('Y-m-d', strtotime($date . ' + ' . $days . ' days'));
        }
    }

    public function update()
    {

        $this->form->validate();

        if ($this->formality->service->name !== ServiceEnum::AGUA->value) {
            $this->form->validate([
                'annual_consumption' => 'required|integer|gt:0',
            ], [
                'annual_consumption.required' => 'Consumo anual requerido',
                'annual_consumption.numeric' => 'Debes rellenar el consumo anual valido',
                'annual_consumption.gt' => 'Consumo anual debe ser mayor que 0',
            ]);
        }
        $this->executeUpdate();

    }

    public function insertData()
    {
        $this->executeUpdate();
    }


    private function executeUpdate()
    {
        DB::beginTransaction();
        try {
            $updates = array_merge(
                $this->form->getDataToUpdate()
            );

            $this->formality->update($updates);

            DB::commit();
            return redirect()->route('admin.formality.total.closed');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function render()
    {
        $reasonCancellation = $this->formalityService->getReasonCancellation();
        return view('livewire.formality.modify-total-closed', ['reasonCancellation' => $reasonCancellation]);
    }
}
