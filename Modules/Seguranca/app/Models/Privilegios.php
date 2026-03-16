<?php

namespace Modules\Seguranca\Models;

use Modules\Base\Models\BaseModel;

class Privilegios extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_privilegios';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'priv_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'priv_label',
        'priv_action'
    ];

    protected $fillable = [
        'priv_label', 'priv_action'
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'priv_label' => "required|max:100",
            'priv_action' => 'required|max:45',
            //'func_id' => 'required|exists:seg_funcionalidades,func_id'
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
            'priv_id' => __('Id privilégio'),
            'priv_label' => __('Nome privilégio'),
            'priv_action' => __('Action privilégio')
        ];
    }

    /**Relação do privilegio pertence a uma funcionalidade 1:N */
    public function funcionalidade()
    {
        return $this->belongsTo(\Modules\Seguranca\Models\Funcionalidades::class, 'func_id');
    }

    /** Relação de muitos pra muitos entre papel e privilegio */
    public function papeis()
    {
        //return $this->belongsToMany(\Modules\Seguranca\Entities\Papeis::class,'seg_privilegios_papeis', 'priv_id', 'papel_id');
    }

    /** Relação de que um privilegio possui varios dependencias 1:N */
    public function dependenciasPrivilegios()
    {
        return $this->hasMany(\Modules\Seguranca\Models\DependenciasPrivilegios::class, 'priv_id');
    }

    /**
     * Retorna os privilegios que o cliente gestor possui acesso
     * ou se não for pra verificar cliente gestor retorna todos
     *
     * @param [type] $funcId
     * @param boolean $checkGestor
     * @return void
     */
    public function getPrivilegios($funcId,  $checkGestor = false)
    {
        if($checkGestor){
            return Privilegios::select('seg_privilegios.*')
            ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.priv_id', '=', 'seg_privilegios.priv_id')
            ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_privilegios_papeis.papel_id')
            ->join('gestor_planos', 'gestor_planos.papel_id', '=', 'seg_papeis.papel_id')
            ->where('gestor_planos.gestor_id', '=', $this->getGestorId())
            ->where('seg_privilegios.func_id', '=', $funcId)
            ->distinct()
            ->orderBy('priv_label','ASC')
            ->get();
        }else{
            return $this->where('func_id', $funcId)->orderBy('priv_label','ASC')->get();
        }
    }

    /**
     * Valida se o gestor possui o privilegio em algum papel
     *
     * @param [type] $privId
     * @return void
     */
    public function validaPrivilegioGestor($privId)
    {
        return !! Privilegios::select('seg_privilegios.priv_id')
            ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.priv_id', '=', 'seg_privilegios.priv_id')
            ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_privilegios_papeis.papel_id')
            ->join('gestor_planos', 'gestor_planos.papel_id', '=', 'seg_papeis.papel_id')
            ->where('gestor_planos.gestor_id', '=', $this->getGestorId())
            ->where('seg_privilegios.priv_id', '=', $privId)
            ->distinct()
            ->orderBy('priv_label','ASC')
            ->first();
    }
}
