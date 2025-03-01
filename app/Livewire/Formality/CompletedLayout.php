<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Component;

class CompletedLayout extends Component
{
    public function render()
    {
        return view('livewire.formality.completed-layout');
    }

    public $files;

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
}
