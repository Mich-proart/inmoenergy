<?php

namespace App\Livewire\Formality;

use App\Models\Company;
use App\Models\Product;
use Livewire\Component;
use App\Domain\Enums\FormalityStatusEnum;
use App\Exceptions\CustomException;
use App\Models\Formality;
use App\Models\User;
use DB;
use App\Domain\Formality\Services\FormalityService;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;

class AssignWorkerToFormalityModal extends Component
{

    public $formality;
    public $formalityId;
    public bool $isCritical = false;
    public $user_assigned_id;

    protected $formalityService;

    public $files;

    public $companyId;
    public $productId;


    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
    }

    public function editFormality($formalityId)
    {
        $this->formality = $this->formalityService->getById($formalityId);
        $this->formalityId = $formalityId;
        $this->isCritical = (bool) $this->formality->isCritical;
    }
    #[Computed()]

    public function workers()
    {
        return User::where('isWorker', true)->where('isActive', 1)->get();
    }

    #[Computed()]

    public function companies()
    {
        return Company::all();
    }
    #[Computed()]
    public function products()
    {
        return Product::where('company_id', $this->companyId)->get();
    }

    protected $rules = [
        'formalityId' => 'required|exists:formality,id',
        'user_assigned_id' => 'required|exists:users,id',
        'isCritical' => 'nullable|boolean',
        'companyId' => 'required|exists:company,id',
        'productId' => 'required|exists:product,id',
    ];

    protected $messages = [
        'formalityId.required' => 'Debes seleccionar un tramite',
        'formalityId.exists' => 'Debes seleccionar un tramite existente',
        'user_assigned_id.required' => 'Debes seleccionar un usuario',
        'user_assigned_id.exists' => 'Debes seleccionar un usuario existente',
        'isCritical.boolean' => 'Debe ser un valor booleano',
        'companyId.required' => 'Debes seleccionar una comercializadora',
        'companyId.exists' => 'Debes seleccionar una comercializadora existente',
        'productId.required' => 'Debes seleccionar un producto',
        'productId.exists' => 'Debes seleccionar un producto existente',
    ];

    public function save()
    {

        $this->validate();
        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::ASIGNADO->value);
            $formality = Formality::firstWhere('id', $this->formalityId);

            $updates = [
                'status_id' => $status->id,
                'user_assigned_id' => $this->user_assigned_id,
                'isCritical' => (bool) $this->isCritical,
                'assignment_date' => now(),
                'company_id' => $this->companyId,
                'product_id' => $this->productId,
            ];

            $updates['previous_company_id'] = $formality->company_id ?? null;

            Formality::firstWhere('id', $this->formalityId)->update($updates);
            DB::commit();
            return redirect()->route('admin.formality.assignment');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
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

    public function render()
    {
        return view('livewire.formality.assign-worker-to-formality-modal');
    }
}
