<?php

namespace App\View\Components\View;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormalityBody extends Component
{
    /**
     * Create a new component instance.
     */

    public $formality;
    public $from;

    public function __construct($formality, $from)
    {
        $this->formality = $formality;
        $this->from = $from;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.view.formality-body');
    }
}
