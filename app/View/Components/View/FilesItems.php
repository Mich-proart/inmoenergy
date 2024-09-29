<?php

namespace App\View\Components\View;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilesItems extends Component
{

    public $files;

    /**
     * Create a new component instance.
     */
    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.view.files-items');
    }
}
