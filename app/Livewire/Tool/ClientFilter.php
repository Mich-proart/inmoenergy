<?php

namespace App\Livewire\Tool;

use App\Domain\Formality\Services\FormalityService;
use App\Domain\Formality\Services\ServicesBasedOnEmail;
use App\Domain\Tool\Dtos\TimeFilterDto;
use App\Models\User;
use App\Models\BusinessGroup;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ClientFilter extends Component
{

    protected FormalityService $formalityService;
    protected ServicesBasedOnEmail $servicesBasedOnEmail;

    protected TimeFilterDto $timeFilterDto;
    public $selectedUsers = [];
    public $selectedServices = [];
    public $selectedBusinessGroups = [];

    public $allUsers = false;
    public $allService = false;
    public $allBusinessGroups = false;

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
            $this->selectedUsers = $this->getUsersQuery()->pluck('id');
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

    public function selectAllBusinessGroups()
    {
        if ($this->allBusinessGroups) {
            $this->selectedBusinessGroups = BusinessGroup::where('is_available', 1)->pluck('id');
        } else {
            $this->selectedBusinessGroups = [];
        }
        // Reset selected users when business groups change
        $this->selectedUsers = [];
        $this->allUsers = false;

        $this->onParamsChange();
    }

    public function isAllCheckBusinessGroups()
    {
        $this->allBusinessGroups = $this->allBusinessGroups ? false : $this->allBusinessGroups;
        // Reset selected users when business groups change
        $this->selectedUsers = [];
        $this->allUsers = false;

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
        $this->dispatch(
            'params-selected',
            searchBasedOn: $this->searchBasedOn,
            selectedUsers: $this->selectedUsers,
            selectedServices: $this->selectedServices,
            from: $this->from,
            to: $this->to,
            selectedFrequency: $this->selectedFrequency,
            selectedBusinessGroups: $this->selectedBusinessGroups,
        );
    }

    private function getUsersQuery()
    {
        if (empty($this->selectedBusinessGroups)) {
            return User::whereRaw('0=1');
        }

        $query = User::where('isWorker', $this->searchBasedOn === 'user_assigned_id')->where('isActive', 1);

        if (!empty($this->selectedBusinessGroups)) {
            $query->whereHas('office', function ($q) {
                $q->whereIn('business_group_id', $this->selectedBusinessGroups);
            });
        }

        return $query;
    }

    public function getUsers()
    {
        return $this->getUsersQuery()->get();
    }

    public function render()
    {
        return view('livewire.tool.client-filter', [
            'users' => $this->getUsers(),
            'services' => $this->formalityService->getServices()->whereNotIn('id', $this->servicesBasedOnEmail->list_ids),
            'businessGroups' => BusinessGroup::where('is_available', 1)->get(),
        ]);
    }
}
