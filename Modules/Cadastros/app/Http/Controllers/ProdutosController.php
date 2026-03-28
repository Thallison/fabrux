<?php

namespace Modules\Cadastros\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Traits\BaseUtils;
use Modules\Cadastros\Http\Requests\ProdutoRequest;

class ProdutosController extends BaseController
{
    use BaseUtils;

    protected function processesDataStore(array $data = [])
    {
        if (!empty($data['prod_tempo_estimado'])) {
            $data['prod_tempo_estimado'] = $this->tempoParaSegundos($data['prod_tempo_estimado']);
        }

        return $data;
    }

    protected function processesDataUpdate(array $data = [])
    {
        if (!empty($data['prod_tempo_estimado'])) {
            $data['prod_tempo_estimado'] = $this->tempoParaSegundos($data['prod_tempo_estimado']);
        }

        return $data;
    }

    protected function getAttributesView()
    {
        return [
            'e' => $this,
        ];
    }
}
