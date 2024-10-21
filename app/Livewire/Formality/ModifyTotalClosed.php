<?php

namespace App\Livewire\Formality;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Enums\FormalityTypeEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Livewire\Forms\Formality\FormalityCancel;
use App\Livewire\Forms\Formality\FormalityModifyTotalClosed;
use App\Models\Address;
use App\Models\ComponentOption;
use App\Models\Formality;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\On;
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

    public function attempCancel()
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

        $this->cancellation->reason_cancellation = ComponentOption::firstWhere('id', $this->cancellation->reason_cancellation_id);
        $this->dispatch('cancel-confirmation');
    }

    public function attemptClose()
    {
        $this->dispatch('closing-confirmation');
    }

    #[On('cancelFormality')]
    public function cancelFormality()
    {
        $trigger_date = now();
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

        try {

            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::BAJA->value);
            $address = $this->createAddressOnCancel($this->formality->address_id);
            $correspondence_address = $this->createAddressOnCancel($this->formality->correspondence_address_id);
            $updates = array_merge(
                $this->cancellation->getDataUpdate(),
                [
                    'status_id' => $status->id,
                    'address_id' => $address->id,
                    'correspondence_address_id' => $correspondence_address->id
                ]
            );

            if ($this->formality) {
                $this->formality->update($updates);
            }

            if ($this->cancellation->create_new_one) {
                $newOne = $this->createFormalityOnCancel($this->formality, $trigger_date);
                $newOne->files()->attach($this->formality->files);
            }

            DB::commit();
            return redirect()->route('admin.formality.total.closed');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    #[On('resetCancellation')]
    public function resetCancellation()
    {
        $this->cancellation->reset();
        $this->cancellation->setData($this->formality);
    }
    public function resetCreateNew()
    {
        $this->cancellation->reset(['assignedId', 'isCritical']);

    }

    private function createFormalityOnCancel($formality, Carbon $trigger_date)
    {
        $inmoenergy = User::firstWhere('name', 'inmoenergy');
        $type = ComponentOption::firstWhere('name', FormalityTypeEnum::ALTA_NUEVA->value);
        $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::ASIGNADO->value);

        return Formality::create([
            'client_id' => $formality->client_id,
            'created_at' => $trigger_date,
            'user_issuer_id' => $inmoenergy->id,
            'service_id' => $formality->service_id,
            'user_assigned_id' => $this->cancellation->assignedId,
            'assignment_date' => $trigger_date,
            'formality_type_id' => $type->id,
            'address_id' => $formality->address_id,
            'correspondence_address_id' => $formality->correspondence_address_id,
            'canClientEdit' => true,
            'status_id' => $status->id,
            'isCritical' => $this->cancellation->isCritical,
            'access_rate_id' => $formality->access_rate_id,
            'CUPS' => $formality->CUPS,
            'internal_observation' => $formality->internal_observation,
            'previous_company_id' => $formality->company_id,
            'potency' => $formality->potency,
            'isRenewable' => true,
        ]);
    }

    private function createAddressOnCancel($previousAddressId)
    {
        $previousAddress = Address::find($previousAddressId);
        return Address::create($previousAddress->toArray());
    }


    public function render()
    {
        $reasonCancellation = $this->formalityService->getReasonCancellation();
        return view('livewire.formality.modify-total-closed', ['reasonCancellation' => $reasonCancellation]);
    }
}
