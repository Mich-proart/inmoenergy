<?php

namespace App\Livewire\Tool;

use App\Domain\Formality\Services\FormalityService;
use App\Domain\Formality\Services\ServicesBasedOnEmail;
use App\Domain\Tool\Dtos\TimeFilterDto;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Filter extends Component
{

    protected FormalityService $formalityService;
    protected ServicesBasedOnEmail $servicesBasedOnEmail;

    protected TimeFilterDto $timeFilterDto;
    public $selectedUsers = [];
    public $selectedServices = [];

    public $allUsers = false;

    public $allService = false;

    public $from;

    public $to;

    public $frequencies = [];

    public $selectedFrequency;

    public $searchBasedOn;


    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
        $this->servicesBasedOnEmail = App::make(ServicesBasedOnEmail::class);
        $this->timeFilterDto = App::make(TimeFilterDto::class);

        $this->from = $this->timeFilterDto->getStartDate();

        $this->to = $this->timeFilterDto->getEndDate();

        $this->frequencies = $this->timeFilterDto->getFrequencyOptions();
    }

    public function mount($searchBasedOn = 'user_assigned_id')
    {
        $this->searchBasedOn = $searchBasedOn;
    }


    public function selectAllUsers()
    {
        if ($this->allUsers) {
            $this->selectedUsers = User::where('isWorker', $this->searchBasedOn === 'user_assigned_id')->where('isActive', 1)->pluck('id');
        } else {
            $this->selectedUsers = [];
        }
        $this->onParamsChange();
    }

    public function isAllCheckUsers()
    {
        $this->allUsers = $this->allUsers ? false : $this->allUsers;
        $this->onParamsChange();
    }

    public function isAllcheckService()
    {
        $this->allService = $this->allService ? false : $this->allService;
        $this->onParamsChange();
    }

    public function selectAllService()
    {
        if ($this->allService) {
            $this->selectedServices = $this->formalityService->getServices()->whereNotIn('id', $this->servicesBasedOnEmail->list_ids)->pluck('id');
        } else {
            $this->selectedServices = [];
        }
        $this->onParamsChange();
    }

    #[Computed()]
    public function frequencyOpt()
    {
        if ($this->from && $this->to) {
            $this->timeFilterDto->setStartDate(new \DateTime($this->from));
            $this->timeFilterDto->setEndDate(new \DateTime($this->to));
            $this->frequencies = $this->timeFilterDto->updateFrequencyOptions();
        }
        return $this->frequencies;

    }

    public function onParamsChange()
    {
        $this->dispatch('params-selected',
            searchBasedOn: $this->searchBasedOn,
            selectedUsers: $this->selectedUsers,
            selectedServices: $this->selectedServices,
            from: $this->from,
            to: $this->to,
            selectedFrequency: $this->selectedFrequency,
        );
    }

    public function getUsers()
    {
        return User::where('isWorker', $this->searchBasedOn === 'user_assigned_id')->where('isActive', 1)->get();
    }

    public function render()
    {
        return view('livewire.tool.filter', [
            'users' => $this->getUsers(),
            'services' => $this->formalityService->getServices()->whereNotIn('id', $this->servicesBasedOnEmail->list_ids)
        ]);
    }
}
