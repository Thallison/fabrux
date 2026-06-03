<?php

namespace Modules\Cadastros\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;

class SetoresController extends BaseController
{
    /**
     * Set atributos da view
     */
    protected function getAttributesView()
    {
        return [
            'e' => $this,
        ];
    }
}
