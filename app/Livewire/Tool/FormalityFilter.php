<?php

namespace App\Livewire\Tool;

use App\Domain\Formality\Services\FormalityService;
use App\Domain\Formality\Services\ServicesBasedOnEmail;
use App\Domain\Tool\Dtos\TimeFilterDto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FormalityFilter extends Component
{

    protected FormalityService $formalityService;
    protected ServicesBasedOnEmail $servicesBasedOnEmail;

    protected TimeFilterDto $timeFilterDto;
    public $selectedServices = [];

    public $allService = false;

    public $from;

    public $to;

    public $frequencies = [];

    public $selectedFrequency;


    public function __construct()
    {
        $this->formalityService = App::make(FormalityService::class);
        $this->servicesBasedOnEmail = App::make(ServicesBasedOnEmail::class);
        $this->timeFilterDto = App::make(TimeFilterDto::class);

        $this->from = $this->timeFilterDto->getStartDate();

        $this->to = $this->timeFilterDto->getEndDate();

        $this->frequencies = $this->timeFilterDto->getFrequencyOptions();
    }

    public function mount()
    {
        // Auto-trigger search on mount with current user
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
        // Get current logged-in user ID
        $currentUserId = Auth::id();
        
        $this->dispatch(
            'params-selected',
            searchBasedOn: 'user_issuer_id',
            selectedUsers: [$currentUserId], // Only current user
            selectedServices: $this->selectedServices,
            from: $this->from,
            to: $this->to,
            selectedFrequency: $this->selectedFrequency,
            selectedBusinessGroups: [], // Not used for formality analysis
        );
    }

    public function render()
    {
        return view('livewire.tool.formality-filter', [
            'services' => $this->formalityService->getServices()->whereNotIn('id', $this->servicesBasedOnEmail->list_ids)
        ]);
    }
}
