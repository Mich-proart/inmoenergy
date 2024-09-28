<?php

namespace App\View\Components\Badge;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RenewableLabel extends Component
{
    /**
     * Create a new component instance.
     */

    public bool $isRenewable;
    public function __construct(bool $isRenewable)
    {
        $this->isRenewable = $isRenewable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge.renewable-label');
    }
}
