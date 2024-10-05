<?php

namespace App\View\Components\Badge;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResolvedTicketLabel extends Component
{
    /**
     * Create a new component instance.
     */
    public bool $isResolved;
    public function __construct(bool $isResolved)
    {
        $this->isResolved = $isResolved;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge.resolved-ticket-label');
    }
}
