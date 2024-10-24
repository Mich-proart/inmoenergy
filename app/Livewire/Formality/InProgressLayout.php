<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Attributes\On;
use Livewire\Component;

class InProgressLayout extends Component
{
    public $files;
    public Formality $formality;

    public function render()
    {
        return view('livewire.formality.in-progress-layout');
    }


    public function getFiles($formality_id)
    {

        $formality = Formality::where('id', $formality_id)->with(
            'files',
            'files.config',
        )->first();

        if ($formality) {
            $this->files = $formality->files;
        }
    }

    #[On('getFormality')]
    public function getFormality($id)
    {
        $this->formality = Formality::where('id', $id)->first();

        if ($this->formality->canClientEdit == 1 && $this->formality->isAvailableToEdit == 1) {
            return redirect()->route('admin.formality.edit', ['id' => $id]);
        } else {
            $this->dispatch('view-formality');
        }
    }

}
