<?php

namespace Modules\Cadastros\Models;

use Illuminate\Support\Facades\DB;
use Modules\Base\Models\BaseModel;

class Produtos extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cad_produtos';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'prod_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'prod_codigo','prod_nome',
    ];

    protected $fillable = [
        'prod_codigo','prod_nome', 
        'prod_tempo_estimado', 'created_at'
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
            'prod_codigo' => "required|unique:cad_produtos,prod_codigo,{$this->prod_id},prod_id",
            'prod_nome' => 'required|max:255',
            'prod_tempo_estimado' => 'required',
            'prod_ativo' => 'required'
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
            'prod_codigo' => __('Código'),
            'prod_nome' => __('Nome'),
            'prod_tempo_estimado' => __('Tempo estimado'),
            'prod_ativo' => __('Status'),
            'created_at' => __('Data criação')
        ];
    }
}
