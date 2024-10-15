<?php

namespace App\View\Components\Table;

use App\Domain\Common\TextAlignment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $headers)
    {
        $this->headers = $this->formatHeaders($this->headers);
    }

    private function formatHeaders(array $headers): array
    {
        return array_map(function ($header) {
            $name = is_array($header) ? $header['name'] : $header;
            return [
                'name' => $name,
                'classes' => $this->textAlignClasses($header['align'] ?? 'left'),
            ];
        }, $headers);
    }

    private function textAlignClasses($align): string
    {
        return [
            'left' => 'text-left',
            'right' => 'text-right',
            'center' => 'text-center',
        ][$align ?? 'text-left'];
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.table');
    }
}
