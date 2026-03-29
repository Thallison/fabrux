<?php

namespace Modules\Producao\Models;

use Illuminate\Http\Request;
use Modules\Base\Models\BaseModel;
use Modules\Cadastros\Models\Funcionarios;
use Modules\Cadastros\Models\Produtos;

class Producoes extends BaseModel
{
    protected $table = 'pro_producoes';

    protected $primaryKey = 'produ_id';

    protected $searchable = [
        'cad_funcionarios.fun_nome',
        'cad_produtos.prod_nome',
        'producoes.produ_data',
        'producoes.produ_quantidade',
    ];

    protected $fillable = [
        'fun_id',
        'prod_id',
        'produ_quantidade',
        'produ_data',
        'produ_hora',
        'produ_tempo_gasto',
    ];

    protected $casts = [
        'produ_data' => 'date:d/m/Y',
        'produ_tempo_gasto' => 'integer',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function rules()
    {
        return [
            'fun_id' => 'required|exists:cad_funcionarios,fun_id',
            'prod_id' => 'required|exists:cad_produtos,prod_id',
            'produ_quantidade' => 'required|integer|min:1',
            'produ_data' => 'required|date',
            'produ_hora' => 'nullable|date_format:H:i',
            'produ_tempo_gasto' => 'nullable|date_format:H:i',
        ];
    }

    public function atribbutesLabel()
    {
        return [
            'fun_id' => __('Funcionário'),
            'prod_id' => __('Produto'),
            'produ_quantidade' => __('Quantidade'),
            'produ_data' => __('Data'),
            'produ_hora' => __('Hora'),
            'produ_tempo_gasto' => __('Tempo gasto'),
            'created_at' => __('Data criação'),
        ];
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class, 'fun_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'prod_id');
    }

    protected function searchSelect($query, $search = null)
    {
        return $query->select(
            'pro_producoes.*',
            'cad_funcionarios.fun_nome as funcionario_nome',
            'cad_produtos.prod_nome as produto_nome'
        );
    }

    protected function searchJoin($query)
    {
        $query->leftJoin('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->leftJoin('cad_produtos', 'cad_produtos.prod_id', '=', 'pro_producoes.prod_id');
    }

    protected function searchWhere($query, $search = null)
    {
        if (!$search) {
            return $query;
        }
        
        return $query->where(function ($q) use ($search) {
            $q->orWhere('cad_funcionarios.fun_nome', 'like', "%{$search}%")
                ->orWhere('cad_produtos.prod_nome', 'like', "%{$search}%")
                ->orWhere('pro_producoes.produ_quantidade', 'like', "%{$search}%")
                ->orWhereRaw("DATE_FORMAT(pro_producoes.produ_data, '%d/%m/%Y') like ?", ["%{$search}%"]);
        });
    }
}
