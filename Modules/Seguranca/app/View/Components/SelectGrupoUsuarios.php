<?php

namespace Modules\Seguranca\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SelectGrupoUsuarios extends Component
{
    public $papeis;
    public $selected;

    public function __construct($papeis, $selected = null)
    {
        $this->papeis = $papeis;
        $this->selected = $selected;
    }


    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('seguranca::components.selectgrupousuarios');
    }
}
