<?php

namespace Modules\Orcamento\Models;

use Modules\Base\Models\BaseModel;
use Modules\Seguranca\Models\Usuarios;

class OrcamentoStatusHistorico extends BaseModel
{
    protected $table = 'orc_status_historicos';

    protected $primaryKey = 'osh_id';

    protected $fillable = [
        'orc_id',
        'usr_id',
        'osh_status_anterior',
        'osh_status_novo',
        'osh_motivo',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class, 'orc_id', 'orc_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usr_id', 'usr_id');
    }
}
