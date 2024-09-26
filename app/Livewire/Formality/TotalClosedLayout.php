<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Component;

class TotalClosedLayout extends Component
{

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

    public function render()
    {
        return view('livewire.formality.total-closed-layout');
    }
}
