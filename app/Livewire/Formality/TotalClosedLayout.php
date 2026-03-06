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
        $this->services = \App\Models\ComponentOption::where('component_id', 2)->get(); // Assuming 2 is service component
        $this->statuses = \App\Models\Status::all();
        $this->companies = \App\Models\Company::all();
        $this->issuers = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'admin'); // Adjust as needed
        })->get();
    }

    public function render()
    {
        return view('livewire.formality.total-closed-layout', [
            'users' => $this->users,
            'services' => $this->services,
            'statuses' => $this->statuses,
            'companies' => $this->companies,
            'issuers' => $this->issuers
        ]);
    }
}
