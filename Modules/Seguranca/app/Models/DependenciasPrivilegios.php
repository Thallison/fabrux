<?php

namespace Modules\Seguranca\Models;

use Modules\Base\Models\BaseModel;

class DependenciasPrivilegios extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_dependencias_privilegios';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'dep_priv_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'dep_priv_controller',
        'dep_priv_action'
    ];

    protected $fillable = [
        'dep_priv_controller', 'dep_priv_action'
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dep_priv_controller' => "required|max:100",
            'dep_priv_action' => 'required|max:45',
            'priv_id' => 'required|exists:seg_privilegios,priv_id'
        ];
    }


    /**
     * Define a relação que uma dependencia possui N privilegios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function privilegios()
    {
        return $this->belongsTo(\Modules\Seguranca\Models\Privilegios::class, 'priv_id');
    }
}
