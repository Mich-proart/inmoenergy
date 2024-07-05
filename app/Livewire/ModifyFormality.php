<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Livewire\Forms\modifyFormalityFields;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Domain\Formality\Services\FormalityService;
use DB;

class ModifyFormality extends Component
{

    public modifyFormalityFields $form;
    protected $formalityService;
    public int $formalityId;
    public $formality;
    public $prevStatus;

    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
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



            DB::commit();
            return redirect()->route('admin.formality.assigned');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
}
