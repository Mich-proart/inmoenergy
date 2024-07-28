<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Component;

class InProgressLayout extends Component
{
    public $files;
    public $formality_file;

    public function render()
    {
        return view('livewire.formality.in-progress-layout');
    }


    public function getFiles($formality_id)
    {
        $formality = Formality::find($formality_id)->with(
            'files',
            'files.config',
            'client',
            'client.files',
            'client.files.config'
        )->first();
        if ($formality) {
            $this->formality_file = $formality->files;
        }
    }

}
