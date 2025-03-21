<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Attributes\On;
use Livewire\Component;

class ClosedLayout extends Component
{

    public $files;

    public Formality $formality;

    #[On('getFormality')]
    public function getFormality($id)
    {
        $this->formality = Formality::where('id', $id)->first();

        if ($this->formality) {
            $this->dispatch('view-formality');
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
        return view('livewire.formality.closed-layout');
    }
}
