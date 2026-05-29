<?php

namespace Modules\Orcamento\Models;

use Modules\Base\Models\BaseModel;
use Modules\Cadastros\Models\Clientes;

class Orcamento extends BaseModel
{
    protected $table = 'orc_orcamentos';

    protected $primaryKey = 'orc_id';

    protected $searchable = [
        'orc_numero',
        'orc_status',
    ];

    protected $fillable = [
        'orc_numero',
        'cli_id',
        'orc_data_emissao',
        'orc_data_validade',
        'orc_desconto_percentual',
        'orc_subtotal',
        'orc_valor_desconto',
        'orc_total',
        'orc_status',
        'orc_observacoes',
    ];

    protected $casts = [
        'orc_data_emissao' => 'date:Y-m-d',
        'orc_data_validade' => 'date:Y-m-d',
        'orc_desconto_percentual' => 'decimal:2',
        'orc_subtotal' => 'decimal:2',
        'orc_valor_desconto' => 'decimal:2',
        'orc_total' => 'decimal:2',
        'created_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cli_id', 'cli_id');
    }

    public function itens()
    {
        return $this->hasMany(OrcamentoItem::class, 'orc_id', 'orc_id');
    }

    public function historicoStatus()
    {
        return $this->hasMany(OrcamentoStatusHistorico::class, 'orc_id', 'orc_id')->orderByDesc('osh_id');
    }

    public function atribbutesLabel()
    {
        return [
            'orc_numero' => __('Numero'),
            'cli_id' => __('Cliente'),
            'orc_data_emissao' => __('Data de criação'),
            'orc_data_validade' => __('Validade'),
            'orc_desconto_percentual' => __('Desconto (%)'),
            'orc_subtotal' => __('Subtotal'),
            'orc_total' => __('Total'),
            'orc_status' => __('Status'),
        ];
    }
}
