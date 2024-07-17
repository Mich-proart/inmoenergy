<?php

namespace App\Livewire;

use App\Domain\Enums\FormalityStatusEnum;
use App\Exceptions\CustomException;
use App\Models\Formality;
use App\Models\User;
use Livewire\Component;
use DB;
use App\Domain\Formality\Services\FormalityService;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;

class AssignWorkerToFormality extends Component
{

    public $formality;
    public $formalityId;
    public bool $isCritical;
    public $user_Assigned_id;

    protected $formalityService;

    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
    }
    public function render()
    {
        return view('livewire.assign-worker-to-formality');
    }

    public function editFormality($formalityId)
    {
        $this->formality = $this->formalityService->getById($formalityId);
        $this->formalityId = $formalityId;
        $this->isCritical = $this->formality->isCritical;
    }
    #[Computed()]

    public function workers()
    {
        return User::where('isWorker', true)->get();
    }

    protected $rules = [
        'formalityId' => 'required|exists:formality,id',
        'user_Assigned_id' => 'required|exists:users,id',
        'isCritical' => 'nullable|boolean',
    ];

    protected $messages = [
        'formalityId.required' => 'Debes seleccionar un tramite',
        'formalityId.exists' => 'Debes seleccionar un tramite existente',
        'user_Assigned_id.required' => 'Debes seleccionar un usuario',
        'user_Assigned_id.exists' => 'Debes seleccionar un usuario existente',
        'isCritical.boolean' => 'Debe ser un valor booleano',
    ];

    public function save()
    {

        $this->validate();
        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::ASIGNADO->value);


            $updates = [
                'formality_status_id' => $status->id,
                'user_Assigned_id' => $this->user_Assigned_id,
                'isCritical' => $this->isCritical,
                'assignment_date' => now()
            ];

            Formality::firstWhere('id', $this->formalityId)->update($updates);
            DB::commit();
            return redirect()->route('admin.formality.assignment');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
}
