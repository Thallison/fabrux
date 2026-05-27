<?php

namespace Modules\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Base\Services\CepService;

class CepController extends Controller
{
    /**
     * Buscar endereço pelo CEP
     *
     * @return JsonResponse
     */
    public function buscar(Request $request)
    {
        $cep = $request->query('cep');

        if (! $cep) {
            return response()->json([
                'success' => false,
                'message' => __('CEP é obrigatório'),
            ], 400);
        }

        $endereco = CepService::buscarEnderecoPorCep($cep);

        if (! $endereco) {
            return response()->json([
                'success' => false,
                'message' => __('CEP não encontrado'),
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $endereco,
        ]);
    }
}
