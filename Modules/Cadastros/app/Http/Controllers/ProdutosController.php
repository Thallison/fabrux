<?php

namespace Modules\Cadastros\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Traits\BaseUtils;

class ProdutosController extends BaseController
{
    use BaseUtils;

    private function normalizarValor(?string $valor): float
    {
        $valor = trim((string) $valor);

        if (str_contains($valor, ',') && str_contains($valor, '.')) {
            // Ex.: 1.234,56 -> 1234.56
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        } elseif (str_contains($valor, ',')) {
            // Ex.: 2,50 -> 2.50
            $valor = str_replace(',', '.', $valor);
        }

        return (float) $valor;
    }

    protected function processesDataStore(array $data = [])
    {
        if (! empty($data['prod_tempo_estimado'])) {
            $data['prod_tempo_estimado'] = $this->tempoParaSegundos($data['prod_tempo_estimado']);
        }

        if (isset($data['prod_valor'])) {
            $data['prod_valor'] = $this->normalizarValor((string) $data['prod_valor']);
        }

        return $data;
    }

    protected function processesDataUpdate(array $data = [])
    {
        if (! empty($data['prod_tempo_estimado'])) {
            $data['prod_tempo_estimado'] = $this->tempoParaSegundos($data['prod_tempo_estimado']);
        }

        if (isset($data['prod_valor'])) {
            $data['prod_valor'] = $this->normalizarValor((string) $data['prod_valor']);
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
