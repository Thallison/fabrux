<?php

namespace Modules\Cadastros\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Cadastros\Models\Clientes;

class ClientesController extends BaseController
{
    /**
     * Metodo para tratar dados que foram enviados via created
     */
    protected function processesDataStore(array $data = [])
    {
        // Gera automaticamente o código se não foi fornecido
        if (empty($data['cli_codigo'])) {
            $data['cli_codigo'] = Clientes::gerarCodigo();
        }

        return $data;
    }

    /**
     * Metodo para tratar dados que foram enviados via edit
     */
    protected function processesDataUpdate(array $data = [])
    {
        // Remove o código para evitar que seja alterado
        unset($data['cli_codigo']);

        return $data;
    }

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
