<?php

namespace App\Livewire\Tool;

use App\Domain\Tool\Services\StatisticService;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\On;
use Livewire\Component;

class Charts extends Component
{

    public array $dataset = [];
    public array $labels = [];

    public int $totalCount;
    public $timeAvg;
    
    public bool $hideTimeAvg = false;
    public bool $groupByService = false;

    protected StatisticService $statisticService;

    public function __construct()
    {
        $this->statisticService = App::make(StatisticService::class);
    }


    public function mount($hideTimeAvg = false, $groupByService = false)
    {
        $this->hideTimeAvg = $hideTimeAvg;
        $this->groupByService = $groupByService;
        $this->dataset = [
            [
                'label' => 'Logged In',
                'data' => [],
            ],
        ];

        $this->labels[] = [];
    }

    #[On('params-selected')]
    public function searchData(string $searchBasedOn, array $selectedUsers, array $selectedServices, string $from, string $to, string|null $selectedFrequency)
    {
        $this->statisticService->setSearchBasedOn($searchBasedOn);
        $data = $this->statisticService->search($selectedUsers, $selectedServices, $from, $to, $selectedFrequency, $this->groupByService);
        $this->totalCount = $data['totalCount'];
        $this->timeAvg = $data['timeAvg'] . ' ' . 'horas';

        $this->dispatch('updateChart',
            $data
        );
    }


    public function render()
    {
        return view('livewire.tool.charts');
    }
}
