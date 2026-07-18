<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Component;
use Livewire\WithFileUploads;

class AssignedLayout extends Component
{
    use WithFileUploads;

    public $files;
    public $formalityId;
    public $showEditFiles = false;
    public $facturaFile;
    public $contratoFile;
    public $invoiceConfig;
    public $contractConfig;
    public $hasFactura = false;
    public $hasContrato = false;

    public function render()
    {
        return view('livewire.formality.assigned-layout');
    }

    public function getFiles($formality_id)
    {
        $this->facturaFile = null;
        $this->contratoFile = null;
        $this->showEditFiles = false;
        $this->formalityId = $formality_id;

        $formality = Formality::where('id', $formality_id)->with(
            'files',
            'files.config',
            'client.files',
            'client.files.config'
        )->first();

        if ($formality) {
            $this->files = $formality->all_files;
            $this->invoiceConfig = \App\Models\FileConfig::where('component_option_id', $formality->service_id)->first();
            $this->contractConfig = \App\Models\FileConfig::where('name', 'contrato del suministro')->first();
            $this->hasFactura = $this->invoiceConfig ? $formality->files->contains('config_id', $this->invoiceConfig->id) : false;
            $this->hasContrato = $this->contractConfig ? $formality->files->contains('config_id', $this->contractConfig->id) : false;
        }
    }

    public function uploadFormalityFiles()
    {
        $this->validate([
            'facturaFile' => 'nullable|file|mimes:pdf,jpg|max:5240',
            'contratoFile' => 'nullable|file|mimes:pdf,jpg|max:5240',
        ], [
            'facturaFile.mimes' => 'El archivo de factura debe ser un PDF o JPG.',
            'facturaFile.max' => 'El archivo de factura debe ser menor a 5MB.',
            'contratoFile.mimes' => 'El archivo de contrato debe ser un PDF o JPG.',
            'contratoFile.max' => 'El archivo de contrato debe ser menor a 5MB.',
        ]);

        $formality = Formality::find($this->formalityId);
        if (!$formality) return;

        $uploaderService = \Illuminate\Support\Facades\App::make(\App\Domain\Program\Services\FileUploadigService::class);

        if ($this->facturaFile && $this->invoiceConfig) {
            $stored_file = $formality->files->where('config_id', $this->invoiceConfig->id)->first();
            $uploader = $uploaderService
                ->setModel($formality)
                ->addFile($this->facturaFile)
                ->setConfigId($this->invoiceConfig->id);

            if ($stored_file) {
                $uploader->force_replace($stored_file);
            } else {
                $folder = $formality->files->first()->folder ?? null;
                $uploader->saveFile($folder);
            }
            $this->facturaFile = null;
        }

        if ($this->contratoFile && $this->contractConfig) {
            $stored_file = $formality->files->where('config_id', $this->contractConfig->id)->first();
            $uploader = $uploaderService
                ->setModel($formality)
                ->addFile($this->contratoFile)
                ->setConfigId($this->contractConfig->id);

            if ($stored_file) {
                $uploader->force_replace($stored_file);
            } else {
                $folder = $formality->files->first()->folder ?? null;
                $uploader->saveFile($folder);
            }
            $this->contratoFile = null;
        }

        $formality->refresh();
        $this->files = $formality->all_files;
        $this->hasFactura = $this->invoiceConfig ? $formality->files->contains('config_id', $this->invoiceConfig->id) : false;
        $this->hasContrato = $this->contractConfig ? $formality->files->contains('config_id', $this->contractConfig->id) : false;

        session()->flash('file_upload_success', 'Archivos guardados correctamente.');
    }
}
