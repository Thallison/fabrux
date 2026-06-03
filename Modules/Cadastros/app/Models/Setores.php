<?php

namespace Modules\Cadastros\Models;

use Modules\Base\Models\BaseModel;

class Setores extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cad_setores';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'set_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'set_codigo',
        'set_nome',
    ];

    protected $fillable = [
        'set_codigo',
        'set_nome',
        'set_ativo',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'set_codigo' => "required|unique:cad_setores,set_codigo,{$this->set_id},set_id",
            'set_nome' => 'required|max:255',
            'set_ativo' => 'required',
        ];
    }

    /**
     * Define o nome dos atributos label para utilizar nos formularios
     *
     * @return array
     */
    public function atribbutesLabel()
    {
        return [
            'set_codigo' => __('Código'),
            'set_nome' => __('Nome'),
            'set_ativo' => __('Status'),
            'created_at' => __('Data criação'),
        ];
    }
}
