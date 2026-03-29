<?php

namespace Modules\Producao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Cadastros\Models\Funcionarios;
use Modules\Cadastros\Models\Produtos;
use Modules\Base\Traits\BaseUtils;

class ProducoesController extends BaseController
{
    use BaseUtils;

     /** Set atributos da view */
    protected function getAttributesView()
    {
        return array(
            'produtos' => Produtos::where('prod_ativo', true)->orderBy('prod_nome', 'ASC')->get(['prod_id', 'prod_nome']),
            'funcionarios' => Funcionarios::where('fun_ativo', true)->orderBy('fun_nome', 'ASC')->get(['fun_id', 'fun_nome']),
            'ranking' => $this->getRanking(),
        );
    }

    public function searchProdutos(Request $request)
    {
        $query = trim($request->input('q', ''));

        $produtos = Produtos::query()
            ->when($query, function ($q) use ($query) {
                $q->where('prod_nome', 'like', "%{$query}%");
            })
            ->orderBy('prod_nome', 'ASC')
            ->limit(20)
            ->get(['prod_id', 'prod_nome']);

        return response()->json($produtos);
    }

    protected function getRanking()
    {
        return $this->getModel()
            ->selectRaw('pro_producoes.fun_id, cad_funcionarios.fun_nome as funcionario_nome, SUM(pro_producoes.produ_quantidade) as total_quantidade, SUM(pro_producoes.produ_tempo_gasto) as total_tempo')
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->groupBy('pro_producoes.fun_id', 'cad_funcionarios.fun_nome')
            ->orderByDesc('total_quantidade')
            ->limit(10)
            ->get();
    }

    protected function processesDataStore(array $data = [])
    {
        if (!empty($data['produ_tempo_gasto'])) {
            $data['produ_tempo_gasto'] = $this->tempoParaSegundos($data['produ_tempo_gasto']);
        }

        return $data;
    }
    
}
