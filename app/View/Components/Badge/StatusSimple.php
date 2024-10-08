<?php

namespace App\View\Components\Badge;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusSimple extends Component
{
    /**
     * Create a new component instance.
     */
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge.status-simple');
    }
}
