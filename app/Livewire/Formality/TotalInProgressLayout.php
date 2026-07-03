<?php

namespace App\Livewire\Formality;

use App\Models\Formality;
use Livewire\Component;
use Livewire\WithFileUploads;

class TotalInProgressLayout extends Component
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
    public $users;
    public $services;
    public $statuses;
    public $companies;
    public $issuers;

    public $selectedUsers = [];
    public $allUsers = false;

    public $selectedServices = [];
    public $allServices = false;

    public $selectedStatuses = [];
    public $allStatuses = false;

    public $selectedCompanies = [];
    public $allCompanies = false;

    public $selectedIssuers = [];
    public $allIssuers = false;

    public $selectedRenewable = [];
    public $allRenewable = false;

    public function selectAllUsers()
    {
        if ($this->allUsers) {
            $this->selectedUsers = $this->users->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function isAllCheckUsers()
    {
        $this->allUsers = $this->allUsers ? false : $this->allUsers;
    }

    public function selectAllServices()
    {
        if ($this->allServices) {
            $this->selectedServices = $this->services->pluck('id')->toArray();
        } else {
            $this->selectedServices = [];
        }
    }

    public function isAllCheckServices()
    {
        $this->allServices = $this->allServices ? false : $this->allServices;
    }

    public function selectAllStatuses()
    {
        if ($this->allStatuses) {
            $this->selectedStatuses = $this->statuses->pluck('id')->toArray();
        } else {
            $this->selectedStatuses = [];
        }
    }

    public function isAllCheckStatuses()
    {
        $this->allStatuses = $this->allStatuses ? false : $this->allStatuses;
    }

    public function selectAllCompanies()
    {
        if ($this->allCompanies) {
            $this->selectedCompanies = $this->companies->pluck('id')->toArray();
        } else {
            $this->selectedCompanies = [];
        }
    }

    public function isAllCheckCompanies()
    {
        $this->allCompanies = $this->allCompanies ? false : $this->allCompanies;
    }

    public function selectAllIssuers()
    {
        if ($this->allIssuers) {
            $this->selectedIssuers = $this->issuers->pluck('id')->toArray();
        } else {
            $this->selectedIssuers = [];
        }
    }

    public function isAllCheckIssuers()
    {
        $this->allIssuers = $this->allIssuers ? false : $this->allIssuers;
    }

    public function selectAllRenewable()
    {
        if ($this->allRenewable) {
            $this->selectedRenewable = [1, 0];
        } else {
            $this->selectedRenewable = [];
        }
    }

    public function isAllCheckRenewable()
    {
        $this->allRenewable = $this->allRenewable ? false : $this->allRenewable;
    }

    public function mount()
    {
        $this->users = \App\Models\User::all();
        $this->services = \App\Models\ComponentOption::where('component_id', 2)->get();
        $this->statuses = \App\Models\Status::all();
        $this->companies = \App\Models\Company::all();
        $this->issuers = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'admin');
        })->get();
    }

    public function render()
    {
        return view('livewire.formality.total-in-progress-layout', [
            'users' => $this->users,
            'services' => $this->services,
            'statuses' => $this->statuses,
            'companies' => $this->companies,
            'issuers' => $this->issuers
        ]);
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
