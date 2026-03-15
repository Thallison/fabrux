<?php

namespace Modules\Seguranca\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SelectModulos extends Component
{
    public $modulos;
    public $selected;

    public function __construct($modulos, $selected = null)
    {
        $this->modulos = $modulos;
        $this->selected = $selected;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('seguranca::components.selectmodulos');
    }
}
