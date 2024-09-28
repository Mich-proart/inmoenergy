<?php

namespace App\View\Components\Badge;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CriticalLabel extends Component
{
    /**
     * Create a new component instance.
     */
    public bool $isCritical;
    public function __construct(bool $isCritical)
    {
        $this->isCritical = $isCritical;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge.critical-label');
    }
}
