<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IcsRecords extends Component
{
    /**
     * Create a new component instance.
     */

    public $ics;

    public function __construct($ics)
    {
        $this->ics = $ics;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.ics-records');
    }
}
