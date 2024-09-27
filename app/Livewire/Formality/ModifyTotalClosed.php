<?php

namespace App\Livewire\Formality;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Livewire\Forms\Formality\FormalityCancel;
use App\Livewire\Forms\Formality\FormalityModifyTotalClosed;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use App\Exceptions\CustomException;
use DB;
use App\Domain\Enums\ServiceEnum;
use App\Models\User;
use Livewire\Attributes\Computed;

class ModifyTotalClosed extends Component
{
    public FormalityModifyTotalClosed $form;
    public FormalityCancel $cancellation;
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
        $this->cancellation->setData($this->formality);
    }

    #[Computed()]

    public function workers()
    {
        return User::where('isWorker', true)->where('isActive', 1)->get();
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

    public function cancelFormality()
    {
        $this->cancellation->validate();

        if ($this->cancellation->create_new_one) {

            $this->cancellation->validate([
                'assignedId' => 'required|integer|exists:users,id',
            ], [
                'assignedId.required' => 'Debes seleccionar un trabajador',
                'assignedId.integer' => 'Debes seleccionar un trabajador',
                'assignedId.exists' => 'Debes seleccionar un trabajador existente',
            ]);
        }

        DB::beginTransaction();
        dd($this->cancellation->assignedId);
        try {

            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::BAJA->value);
            $updates = array_merge(
                $this->cancellation->getDataUpdate(),
                [
                    'status_id' => $status->id
                ]
            );

            if ($this->formality) {
                $this->formality->update($updates);
            }
            DB::commit();
            return redirect()->route('admin.formality.total.closed');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    public function resetCancellation()
    {
        $this->cancellation->reset();
        $this->cancellation->setData($this->formality);
    }
    public function resetCreateNew()
    {
        $this->cancellation->reset(['assignedId', 'isCritical']);

    }


    public function render()
    {
        $reasonCancellation = $this->formalityService->getReasonCancellation();
        return view('livewire.formality.modify-total-closed', ['reasonCancellation' => $reasonCancellation]);
    }
}
