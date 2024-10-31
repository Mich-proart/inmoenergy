<?php

namespace App\Livewire\Formality;

use App\Domain\Enums\FormalityTypeEnum;
use App\Models\Address;
use App\Models\ComponentOption;
use App\Models\Formality;
use Carbon\Carbon;
use Livewire\Component;
use App\Exceptions\CustomException;
use DB;
use App\Models\User;
use Livewire\Attributes\Computed;
use App\Domain\Formality\Services\FormalityService;
use Illuminate\Support\Facades\App;
use App\Domain\Enums\FormalityStatusEnum;

class AssignmentRevonationLayout extends Component
{

    public $files;

    public $formality;

    public $formalityId;

    public bool $isCritical;
    public $user_assigned_id;
    protected $formalityService;

    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
    }

    protected $rules = [
        'formalityId' => 'required|exists:formality,id',
        'user_assigned_id' => 'required|exists:users,id',
        'isCritical' => 'nullable|boolean',
    ];

    protected $messages = [
        'formalityId.required' => 'Debes seleccionar un tramite',
        'formalityId.exists' => 'Debes seleccionar un tramite existente',
        'user_assigned_id.required' => 'Debes seleccionar un usuario',
        'user_assigned_id.exists' => 'Debes seleccionar un usuario existente',
        'isCritical.boolean' => 'Debe ser un valor booleano',
    ];

    public function editFormality($formalityId)
    {
        $this->formality = $this->formalityService->getById($formalityId);
        $this->formalityId = $formalityId;
        $this->isCritical = $this->formality->isCritical;
    }

    public function getFiles($formality_id)
    {

        $formality = Formality::where('id', $formality_id)->with(
            'files',
            'files.config'
        )->first();

        if ($formality) {
            $this->files = $formality->files;

        }
    }

    #[Computed()]

    public function workers()
    {
        return User::where('isWorker', true)->where('isActive', 1)->get();
    }

    public function save()
    {
        $trigger_date = now();
        $this->validate();
        DB::beginTransaction();

        try {
            $formality = Formality::firstWhere('id', $this->formalityId);
            $address = $this->createAddressOnRenovation($this->formality->address_id);
            $correspondence_address = $this->createAddressOnRenovation($this->formality->correspondence_address_id);

            $updates = [
                'address_id' => $address->id,
                'correspondence_address_id' => $correspondence_address->id,
                'isRenovated' => true,
            ];
            $formality->update($updates);

            $newOne = $this->createFormalityOnRenovation($formality, $trigger_date);
            $newOne->files()->attach($formality->files);

            DB::commit();
            return redirect()->route('admin.formality.assignment.renovation');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    private function createFormalityOnRenovation($formality, Carbon $trigger_date)
    {
        $inmoenergy = User::firstWhere('name', 'inmoenergy');
        $type = ComponentOption::firstWhere('name', FormalityTypeEnum::RENOVACION->value);
        $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::ASIGNADO->value);

        return Formality::create([
            'client_id' => $formality->client_id,
            'created_at' => $trigger_date,
            'user_issuer_id' => $inmoenergy->id,
            'service_id' => $formality->service_id,
            'user_assigned_id' => $this->user_assigned_id,
            'assignment_date' => $trigger_date,
            'formality_type_id' => $type->id,
            'address_id' => $formality->address_id,
            'correspondence_address_id' => $formality->correspondence_address_id,
            'canClientEdit' => true,
            'status_id' => $status->id,
            'isCritical' => $this->isCritical,
            'access_rate_id' => $formality->access_rate_id,
            'CUPS' => $formality->CUPS,
            'internal_observation' => $formality->internal_observation,
            'previous_company_id' => $formality->company_id,
            'company_id' => $formality->company_id,
            'potency' => $formality->potency,
            'isRenewable' => true,
        ]);
    }

    private function createAddressOnRenovation($previousAddressId)
    {
        $previousAddress = Address::find($previousAddressId);
        return Address::create($previousAddress->toArray());
    }


    public function render()
    {
        return view('livewire.formality.assignment-revonation-layout');
    }
}
