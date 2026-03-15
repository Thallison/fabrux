<?php

namespace Modules\Seguranca\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Seguranca\Models\Modulos;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class FuncionalidadesController extends BaseController
{
    /** Cadastro de funcionalidade */
    public function store(Request $request)
    {
        $dados = $request->all();

        if(!$dados['privilegios']){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'warning',
                'text' => 'Necessário cadastrar pelo menos 1 privilégio.'
            ]);
        }

        $this->validaRoles($request, $this->getModel());

        $func = $this->getModel()->create($dados);

        foreach($dados['privilegios'] as $priv){
            $func->privilegios()->create($priv);
        }

        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => 'success',
            'text' => 'Cadastro realizado com sucesso'
        ]);
    }
    
    /** Set atributos da view */
    protected function getAttributesView()
    {
        return array(
            'modulos' => $this->getAllModulos(),
            'funcAll' => $this->getAllFuncionalidades()
        );
    }    

    
    /** Busca Todas os sistemas cadastrados */
    private function getAllModulos()
    {
        $modModel = new Modulos();

        $modulos = $modModel
            ->orderBy('mod_nome','ASC')
            ->get(['mod_nome','mod_id'])
            ->pluck('mod_nome', 'mod_id')
            ->toArray();

        return $modulos;
    }

    /** Busca Todas os sistemas cadastrados */
    private function getAllFuncionalidades()
    {
        $func = $this->getModel()
            ->orderBy('func_label','ASC')
            ->get(['func_id','func_label'])
            ->pluck('func_label', 'func_id')
            ->toArray();

        return $func;
    }
}
