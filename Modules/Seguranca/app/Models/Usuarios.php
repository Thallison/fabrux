<?php

namespace Modules\Seguranca\Models;

use DateTime;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuarios extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_usuarios';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'usr_id';


    protected $fillable = [
        'usr_login', 'email', 'usr_name', 'usr_status', 'password',
        'usr_dt_ultimo_acesso', 'usr_dt_alteracao', 'usr_dt_criacao'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        //'birthday'  => 'date:Y-m-d',
        'usr_dt_ultimo_acesso' => 'datetime:d/m/Y H:i:s',
        'usr_dt_alteracao' => 'datetime:d/m/Y H:i:s',
        'usr_dt_criacao' => 'datetime:d/m/Y H:i:s',
    ];

    public function rules()
    {
        return [
            'usr_login' => "required|max:50|unique:seg_usuarios,usr_login,{$this->usr_id},usr_id",
            'password' => 'max:255',
            'senha' => 'max:255',
            'usr_name' => 'required|max:100',
            'email' => "required|email|max:255|unique:seg_usuarios,email,{$this->usr_id},usr_id",
            'usr_status' => 'required'
        ];
    }

    public function atribbutesLabel()
    {
        return [
            'usr_id' => __('#'),
            'usr_login' => ('Login'),
            'password' => __('Senha'),
            'usr_name' => __('Nome'),
            'email' => __('E-mail'),
            'usr_status' => __('Status'),
            'usr_dt_criacao' => __('Data criação'),
            'usr_dt_alteracao' => __('Data alteração'),
            'usr_dt_ultimo_acesso' => __('Data ultimo acesso'),
        ];
    }

    /**
     * Retorna o nome dos atributos definido na entidade
     * pelo metodo atribbutesLabel
     */
    public function getAttributeLabel($key)
    {
        if(method_exists($this, 'atribbutesLabel')){
            return $this->atribbutesLabel()[$key];
        }
    }

    /**
     * search
     * Utilizado para implementar o serach do grid do bootstrap-table
     *
     * @return array
     */
    public function search()
    {
        $query = $this->query();
        $this->searchSelect($query);
        $this->searchJoin($query);
        $this->searchWhere($query);

        $total = $query->count();

        return ['total' => $total, 'rows' => $query->get()];

    }

    /**
     * Utilizado para alterar o select utilizado na grid bootstrap table
     *
     * @param object $data
     * @return void
     */
    protected function searchSelect($query, $search = null)
    {
        if (!$search || empty($this->searchable)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

    /**
     * Utilizado para alterar o join utilizado na grid bootstrap table
     *
     * @param object $query
     * @return void
     */
    protected function searchJoin($query)
    {
    }

    /**
     * Utilizado para definir as restrições where
     *
     * @param object $query utilizado para a query da grid
     * @return void
     */
    protected function searchWhere($query)
    {
    }

    /**
     * utilizado para ordenar os registros
     *
     * @param object $query
     * @return void
     */
    protected function searchOrderby($query, $sort, $order)
    {
        return $query->orderBy($sort, $order);
    }

    /** Relação de muitos pra muitos entre papel e privilegio */
    public function papeisUsuario()
    {
        return $this->belongsToMany(\Modules\Seguranca\Models\Papeis::class,'seg_usuarios_papeis', 'usr_id', 'papel_id');
    }

    /** Relação de muitos pra muitos entre sistemas e usuario */
    public function sistemasUsuario()
    {
        return $this->belongsToMany(\Modules\Seguranca\Models\Sistemas::class, 'seg_sistemas_usuarios', 'usr_id', 'sis_id');
    }

    /** Relação de que um sistema possui varios logs 1:N */
    public function logs()
    {
        return $this->hasMany(\Modules\Seguranca\Models\Logs::class, 'usr_id');
    }

    /**
     * Este metodo atualiza os sistemas do usuario de acordo com os
     * papeis cadastrados pra ele
     *
     * @return boolean
     */
    public function atualizaSistemasUsuario()
    {
        if(!$this->usr_id){
            return false;
        }

        if($this->papeisUsuario()->get()->count()){
            $sistemas = [];
            foreach ($this->papeisUsuario()->get() as $papel){
                $sistemas[] = $papel->getSistemasPapeis();//papel é obrigado a ter sistemas
            }
            $this->sistemasUsuario()->sync($this->organizaSistema($sistemas));
            return true;
        }else{
            return false;
        }
    }

    /**Organiza os ids dos sistemas para que retorne um array unico */
    private function organizaSistema(array $sistemas)
    {
        $arrSistema = [];
        foreach($sistemas as $sistema){
            foreach ($sistema as $sis){
                if(!in_array($sis, $arrSistema)){
                    $arrSistema[] = $sis;
                }
            }
        }

        return $arrSistema;
    }

    /**
     * Cadastra usuario
     *
     * @param array $dados
     * @return object
     */
    public function cadastraUsuario(array $dados)
    {
        $dados['usr_dt_criacao'] = new DateTime();
        $usuario = $this->create($dados);
        $usuario->papeisUsuario()->sync($dados['papeis']);
        $usuario->sistemasUsuario()->sync($dados['sistemas']);

        return $usuario;
    }

    /**Função para atualizar o usuário */
    public function atualizaUsuario(array $dados)
    {
        if(!$this) return false;

        $dados['usr_dt_alteracao'] = new \DateTime();
        $this->update($dados);
        $this->papeisUsuario()->sync($dados['papeis']);
        $this->sistemasUsuario()->sync($dados['sistemas']);

        return $this;
    }

    /**
     * Metodo para retornar os dados da entidade a ser procurada
     *
     * Sobreescrever esse metodo no model para tratar dados apenas do gestor atual
     * @param [type] $id
     * @return void
     */
    public function findData($id)
    {
        return $this->findOrFail($id);
    }
}