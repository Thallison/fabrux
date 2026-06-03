<?php

namespace Modules\Cadastros\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'fun_nome',
        'set_nome',
    ];

    protected $fillable = [
        'fun_codigo', 'fun_nome', 'fun_carga_horaria',
        'fun_set_id', 'fun_ativo', 'created_at'
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
            'fun_set_id' => 'required|exists:cad_setores,set_id',
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
            'fun_set_id' => __('Setor'),
            'set_nome' => __('Setor'),
            'fun_ativo' => __('Status'),
            'created_at' => __('Data criação')
        ];
    }

    protected function searchSelect($query)
    {
        $query->select('cad_funcionarios.*', 'cad_setores.set_nome');
    }

    protected function searchJoin($query)
    {
        $query->leftJoin('cad_setores', 'cad_setores.set_id', '=', 'cad_funcionarios.fun_set_id');
    }

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setores::class, 'fun_set_id', 'set_id');
    }
}
