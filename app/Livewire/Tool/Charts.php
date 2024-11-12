<?php

namespace App\Livewire\Tool;

use Livewire\Attributes\On;
use Livewire\Component;

class Charts extends Component
{

    public array $dataset = [];
    public array $labels = [];


    public function mount()
    {
        $this->dataset = [
            [
                'label' => 'Logged In',
                'data' => $this->getRandomData(),
            ],
        ];

        $this->labels[] = $this->getLabels();
    }

    #[On('params-selected')]
    public function searchData(array $selectedAssigneds, array $selectedServices, string $from, string $to, string $selectedFrequency)
    {

        $this->dispatch('updateChart',
            datasets: [
                [
                    'label' => '# of Votes',
                    'data' => [12, 19, 3, 5, 2, 3],
                    'borderWidth' => 1
                ]
            ],
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
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
