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

    protected StatisticService $statisticService;

    public function __construct()
    {
        $this->statisticService = App::make(StatisticService::class);
    }


    public function mount()
    {
        $this->dataset = [
            [
                'label' => 'Logged In',
                'data' => [],
            ],
        ];

        $this->labels[] = [];
    }

    #[On('params-selected')]
    public function searchData(string $searchBasedOn, array $selectedUsers, array $selectedServices, string $from, string $to, string $selectedFrequency)
    {
        $this->statisticService->setSearchBasedOn($searchBasedOn);
        $data = $this->statisticService->search($selectedUsers, $selectedServices, $from, $to, $selectedFrequency);
        $this->totalCount = $data['totalCount'];
        $this->timeAvg = $data['timeAvg'] . ' ' . 'días';

        $this->dispatch('updateChart',
            $data
        );
    }

    private function getLabels()
    {
        $labels = [];
        for ($i = 0; $i < 12; $i++) {
            $labels[] = now()->subMonths($i)->format('M');
        }
        return $labels;
    }

    private function getRandomData()
    {
        $data = [];
        for ($i = 0; $i < count($this->getLabels()); $i++) {
            $data[] = rand(10, 100);
        }
        return $data;
    }


    public function render()
    {
        return view('livewire.tool.charts');
    }
}
