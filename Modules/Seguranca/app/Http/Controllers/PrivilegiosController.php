<?php

namespace Modules\Seguranca\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Seguranca\Models\Modulos;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Seguranca\Models\DependenciasPrivilegios;

class PrivilegiosController extends BaseController
{
    public function show($id)
    {
        $model = $this->getModel();
        $dados = $model->findOrFail($id);

        $modelDependencia = new DependenciasPrivilegios();
        $privDependencia = $modelDependencia->where('priv_id', $id)->get();

        $attributeView = array_merge($this->getAttributesView(), [
            'dados' =>$dados,
            'model' => $model,
            'privDependencia' => $privDependencia
        ]);

        return view($this->getRota().".show", $attributeView);
    }

    public function update(Request $request, $id)
    {
        $dados = $request->all();
        $retEntity = $this->getModel()->findOrFail($id);

        $this->validaRoles($request, $retEntity);
        $retEntity->update($dados);

        if(isset($dados['depPrivilegios'])){
            foreach($dados['depPrivilegios'] as $priv){
                $retEntity->dependenciasPrivilegios()->create($priv);
            }
        }

        $mensagem = 'Registro editado com sucesso.';
        $type = 'success';

        if($request->input('_dataType') == 'json'){
            return $this->getResponseJson(['message' => $mensagem, 'type' => $type]);
        }

        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => $type,
            'text' => $mensagem
        ]);
    }

    /**Deletar dependencia do privilegio */
    public function destroyDep($id)
    {
        try {
            $dados = (new DependenciasPrivilegios())->findOrFail($id);
            $dados->delete();
            $mensagem = 'Exclusão realizada com sucesso.';
            $type = 'success';
        } catch (\Exception $th) {
            $mensagem = 'Ocorreu um erro ao excluir o registro. Verifique se o registro não possui vinculos.';
            $type = 'danger';
        }

        return $this->getResponseJson(['message' => $mensagem, 'type' => $type]);
    }
}
