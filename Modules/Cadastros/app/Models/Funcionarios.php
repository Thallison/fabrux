<?php

namespace Modules\Cadastros\Models;

use Illuminate\Support\Facades\DB;
use Modules\Base\Models\BaseModel;

class Funcionarios extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cad_funcionarios';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'fun_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'fun_codigo',
        'fun_nome'
    ];

    protected $fillable = [
        'fun_codigo', 'fun_nome', 'fun_carga_horaria',
        'fun_ativo', 'created_at'
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
            'fun_codigo' => "required|unique:cad_funcionarios,fun_codigo,{$this->fun_id},fun_id",
            'fun_nome' => 'required|max:255',
            'fun_carga_horaria' => 'required',
            'fun_ativo' => 'required'
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
            'fun_codigo' => __('Código/matrícula'),
            'fun_nome' => __('Nome'),
            'fun_carga_horaria' => __('Carga Horaria'),
            'fun_ativo' => __('Status'),
            'created_at' => __('Data criação')
        ];
    }
}
