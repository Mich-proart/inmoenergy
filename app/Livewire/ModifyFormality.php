<?php

namespace App\Livewire;

use App\Domain\Enums\FormalityStatusEnum;
use App\Exceptions\CustomException;
use App\Livewire\Forms\modifyFormalityFields;
use App\Models\Company;
use App\Models\Formality;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Domain\Formality\Services\FormalityService;
use DB;
use Livewire\Attributes\Computed;

class ModifyFormality extends Component
{

    public modifyFormalityFields $form;
    protected $formalityService;
    public $formality;
    public $prevStatus;

    public $companyId;

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


    public function render()
    {
        $accessRate = $this->formalityService->getAccessRates();
        return view('livewire.modify-formality', compact(['accessRate']));
    }

    public function mount($formality, $prevStatus)
    {
        $this->formality = $formality;
        $this->prevStatus = $prevStatus;
    }

    public function update()
    {
        $this->form->validate();


        DB::beginTransaction();

        try {
            $status = $this->formalityService->getFormalityStatus(FormalityStatusEnum::TRAMITADO->value);
            $updates = array_merge(
                $this->form->getDataToUpdate(),
                [
                    'completion_date' => now(),
                    'formality_status_id' => $status->id
                ]
            );

            Formality::firstWhere('id', $this->formality->formality_id)->update($updates);
            DB::commit();
            return redirect()->route('admin.formality.assigned');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
}
