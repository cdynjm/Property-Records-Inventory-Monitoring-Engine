<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $name;
    public $class;

    public function __construct($name = null, $class = null)
    {
        $this->name = $name;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.modal');
    }
}
