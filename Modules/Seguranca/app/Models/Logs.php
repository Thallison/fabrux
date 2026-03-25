<?php

namespace Modules\Seguranca\Models;

use Illuminate\Support\Facades\DB;
use Modules\Base\Models\BaseModel;

class Logs extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_logs';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'log_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'log_controller', 'log_action', 'log_nome_rota',
        'created_at', 'log_msg', 'log_tipo'
    ];

    
    protected $casts = [
        //'birthday'  => 'date:Y-m-d',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    protected $fillable = [
        'log_controller', 'log_action', 'log_nome_rota',
        'created_at', 'log_msg', 'log_tipo'
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'log_controller' => "required|max:100",
            'log_action' => 'required|max:45',
            'log_nome_rota' => 'max:100',
            'log_msg' => 'required',
            'log_tipo' => 'required'
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
            'log_id' => __('#'),
            'log_controller' => __('Controller'),
            'log_action' => __('Action'),
            'log_nome_rota' => __('Nome da rota'),
            'created_at' => __('Data inclusão'),
            'log_msg' => __('Mensagem'),
            'log_tipo' => __('Tipo'),
            'usr_id' => __('Id usuário')
        ];
    }

     /**Relação do log pertence a um usuario 1:N */
    public function usuario()
    {
        return $this->belongsTo(\Modules\Seguranca\Models\Usuarios::class, 'usr_id');
    }

    protected function searchOrderby($query, $sort, $order)
    {
        if($sort || $order)
        {
            $query->orderBy($sort, $order);
        }
        else
        {
            $query->orderBy('log_id', 'DESC');
        }
        
        return $query;
    }
}
