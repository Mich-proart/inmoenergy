<?php

namespace App\Livewire\Formality;

use App\Domain\Formality\Services\FormalityService;
use App\Livewire\Forms\Formality\FormalityComissionEdit;
use App\Models\Formality;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\On;
use Livewire\Component;
use DB;
use App\Exceptions\CustomException;

class EditCommisionModal extends Component
{

    public $files;

    public FormalityComissionEdit $form;

    protected $formalityService;

    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
    }

    public function save()
    {
        $this->form->validate();

        if ($this->form->commission == null || $this->form->commission == '' || $this->form->commission == 0) {
            $this->dispatch('checks', error: "Por favor, rellene la comision correctamente", title: "Valor no valido");
        } else {
            $this->executeSave();
        }


    }

    private function executeSave()
    {
        DB::beginTransaction();

        try {

            $formality = $this->formalityService->getById($this->form->formalityId);

            if ($formality) {
                $updates = array_merge(
                    $this->form->getDataToUpdate()
                );
                $formality->update($updates);
            }
            DB::commit();
            return redirect()->route('admin.formality.commission.manager');
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

    public function closeClean()
    {
        $this->form->reset([
            'commission',
        ]);
    }

    #[On('startEditing')]
    public function startEditing($formality_id)
    {
        $this->form->setId($formality_id);
        $formality = $this->formalityService->getById($formality_id);
        $this->form->commission = $formality->getCommision();

        if ($this->form->commission != 0 || $this->form->commission != null || $this->form->commission != '') {
            $commission = $this->form->number_format_spanish($this->form->commission);
            $this->form->commission = $commission;
        }

    }

    public function render()
    {
        return view('livewire.formality.edit-commision-modal');
    }
}
