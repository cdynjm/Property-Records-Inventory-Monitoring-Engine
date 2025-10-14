<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AreRecords extends Component
{
    /**
     * Create a new component instance.
     */

    public $are;

    public function __construct($are)
    {
        $this->are = $are;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.are-records');
    }
}
