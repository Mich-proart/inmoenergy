<?php

namespace App\Livewire\Formality;

use App\Domain\Enums\ServiceEnum;
use App\Livewire\Forms\Formality\FormalityModify;
use App\Models\User;
use Livewire\Component;
use App\Domain\Enums\FormalityStatusEnum;
use App\Exceptions\CustomException;
use App\Models\Company;
use App\Models\Formality;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use App\Domain\Formality\Services\FormalityService;
use DB;
use Livewire\Attributes\Computed;

class ModifyFormalityForm extends Component
{

    public FormalityModify $form;

    protected $formalityService;
    public $formality;
    public $prevStatus;

    public $companyId;

    public $accessRate;

    public $from = null;

    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
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

    #[Computed()]

    public function workers()
    {
        return User::where('isWorker', true)->where('isActive', 1)->get();
    }

    public function mount($formality, $prevStatus, $from)
    {
        $this->formality = $formality;
        $this->accessRate = $this->formalityService->getAccessRates($this->formality->service->name);
        $this->companyId = $formality->product->company->id ?? null;
        $this->form->setData($this->formality);
        $this->prevStatus = $prevStatus;

        if ($from) {
            $this->from = $from;
        }
    }

    public function update()
    {
        $this->form->validate();

        if ($this->formality->service->name !== ServiceEnum::AGUA->value) {
            $this->form->validate([
                'CUPS' => 'required|string|min:20|max:22',
                'access_rate_id' => 'required|integer|exists:component_option,id',
                'annual_consumption' => 'required|numeric|gt:0',
                'potency' => 'required|numeric|gt:0',
            ], [
                'CUPS.required' => 'Debes rellenar el CUPS',
                'CUPS.string' => 'Debes rellenar el CUPS',
                'CUPS.min' => 'Minimo 20 caracteres',
                'CUPS.max' => 'Maximo 22 caracteres',
                'access_rate_id.required' => 'Debes seleccionar una tarifa de acceso',
                'access_rate_id.integer' => 'Debes seleccionar una tarifa de acceso',
                'access_rate_id.exists' => 'Debes seleccionar una tarifa de acceso existente',
                'annual_consumption.required' => 'Consumo anual requerido',
                'annual_consumption.numeric' => 'Debes rellenar el consumo anual valido',
                'annual_consumption.gt' => 'Consumo anual debe ser mayor que 0',
                'potency.required' => 'Debes rellenar la potencia',
                'potency.numeric' => 'Debes rellenar la potencia',
                'potency.gt' => 'Debes rellenar la potencia',
            ]);
        }

        if (isset($this->from) && $this->from == 'total') {
            $this->form->validate(
                [
                    'user_assigned_id' => 'required|integer|exists:users,id',
                ],
                [
                    'user_assigned_id.required' => 'Debes seleccionar un usuario',
                    'user_assigned_id.integer' => 'Debes seleccionar un usuario',
                    'user_assigned_id.exists' => 'Debes seleccionar un usuario existente',
                ]
            );
        }

        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::TRAMITADO->value);
            $updates = array_merge(
                $this->form->getDataToUpdate(),
                [
                    'completion_date' => now(),
                    'status_id' => $status->id
                ]
            );

            $data = Formality::firstWhere('id', $this->formality->id);

            if ($data->user_assigned_id !== $this->form->user_assigned_id) {
                $updates['user_assigned_id'] = $this->form->user_assigned_id;
                $updates['assignment_date'] = now();
            }

            $data->update($updates);

            DB::commit();
            return redirect()->route('admin.formality.completed');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
    public function insertData()
    {

        $this->form->validate([
            'product_id' => 'required|integer|exists:product,id',
            'previous_company_id' => 'required|integer|exists:company,id',
        ], [
            'product_id.integer' => 'Debes seleccionar un producto',
            'product_id.exists' => 'Debes seleccionar un producto existente',
            'previous_company_id.integer' => 'Debes seleccionar una empresa',
            'previous_company_id.exists' => 'Debes seleccionar una empresa existente',
            'product_id.required' => 'Debes seleccionar un producto',
            'previous_company_id.required' => 'Debes seleccionar una empresa',
        ]);

        $data = Formality::firstWhere('id', $this->formality->id);

        if ($data->user_assigned_id && ($this->form->user_assigned_id == null || $this->form->user_assigned_id == 0 || $this->form->user_assigned_id == '')) {
            $this->form->validate(
                [
                    'user_assigned_id' => 'required|integer|exists:users,id',
                ],
                [
                    'user_assigned_id.required' => 'Debes seleccionar un usuario',
                    'user_assigned_id.integer' => 'Debes seleccionar un usuario',
                    'user_assigned_id.exists' => 'Debes seleccionar un usuario existente',
                ]
            );
        }

        DB::beginTransaction();
        try {
            $updates = array_merge(
                $this->form->getDataToUpdate(),
                [
                    'completion_date' => now()
                ]
            );


            if ($data->user_assigned_id !== $this->form->user_assigned_id) {
                $updates['user_assigned_id'] = $this->form->user_assigned_id;
                $updates['assignment_date'] = now();
            }

            $data->update($updates);


            DB::commit();
            return redirect()->route('admin.formality.completed');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.formality.modify-formality-form');
    }
}