<?php

namespace Modules\Cadastros\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Traits\BaseUtils;

class FuncionariosController extends BaseController
{
    use BaseUtils;
    
    /**
     * Metodo para tratar dados que foram enviados via created
     */
    protected function processesDataStore(array $data = [])
    {
        $data['fun_carga_horaria'] = $this->tempoParaSegundos($data['fun_carga_horaria']);
        return $data;
    }

    /**
     * Metodo para tratar dados que foram enviados via edit
     */
    protected function processesDataUpdate(array $data = [])
    {
        $data['fun_carga_horaria'] = $this->tempoParaSegundos($data['fun_carga_horaria']);
        return $data;
    }

     /** Set atributos da view */
    protected function getAttributesView()
    {
        return array(
            'e' => $this,
        );
    } 
    
}
