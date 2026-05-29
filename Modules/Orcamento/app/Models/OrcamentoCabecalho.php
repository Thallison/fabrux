<?php

namespace Modules\Orcamento\Models;

use Modules\Base\Models\BaseModel;

class OrcamentoCabecalho extends BaseModel
{
    protected $table = 'orc_cabecalhos';

    protected $primaryKey = 'orc_cab_id';

    protected $fillable = [
        'orc_cab_nome',
        'orc_cab_documento',
        'orc_cab_endereco',
        'orc_cab_telefone',
        'orc_cab_email',
        'orc_cab_site',
        'orc_cab_rodape',
    ];
}
