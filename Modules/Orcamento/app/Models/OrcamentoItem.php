<?php

namespace Modules\Orcamento\Models;

use Modules\Base\Models\BaseModel;
use Modules\Cadastros\Models\Produtos;

class OrcamentoItem extends BaseModel
{
    protected $table = 'orc_orcamento_itens';

    protected $primaryKey = 'oci_id';

    protected $fillable = [
        'orc_id',
        'prod_id',
        'oci_produto_codigo',
        'oci_produto_nome',
        'oci_quantidade',
        'oci_valor_unitario',
        'oci_total',
    ];

    protected $casts = [
        'oci_quantidade' => 'decimal:3',
        'oci_valor_unitario' => 'decimal:2',
        'oci_total' => 'decimal:2',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class, 'orc_id', 'orc_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'prod_id', 'prod_id');
    }
}
