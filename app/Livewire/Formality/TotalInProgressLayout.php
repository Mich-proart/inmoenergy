<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Component;

class TotalInProgressLayout extends Component
{
    public function render()
    {
        return view('livewire.formality.total-in-progress-layout');
    }

    public $files;
    public $formality_file;

    public function getFiles($formality_id)
    {

        $formality = Formality::where('id', $formality_id)->with(
            'files',
            'files.config',
            'client',
            'client.files',
            'client.files.config'
        )->first();

        if ($formality) {
            $this->formality_file = $formality->files;

        }

        $this->files = $formality->client->files;
    }
}
