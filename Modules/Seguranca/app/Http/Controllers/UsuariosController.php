<?php

namespace Modules\Seguranca\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Seguranca\Models\Papeis;
use Modules\Seguranca\Models\Usuarios;
use Modules\Seguranca\Traits\UsuariosTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Modules\Seguranca\Logging\BaseLog;

class UsuariosController extends BaseController
{
    use UsuariosTraits;

    public function store(Request $request)
    {
        $dados = $request->all();

        $this->validaRoles($request, $this->getModel());

        if($this->validaSenha($dados['senha'], $dados['repeat_senha'])){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'danger',
                'text' => 'Senhas não conferem'
            ]);
        }

        list($papeis, $sistemas) = $this->verificaPapeisSistema($dados);
        if(!is_array($papeis)){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'danger',
                'text' => 'Seleciona um perfil para o usuário.'
            ]);
        }

        $dados['papeis'] = $papeis;
        $dados['sistemas'] = $sistemas;
        $dados['password'] = Hash::make($dados['senha']);

        $this->getModel()->cadastraUsuario($dados);

        BaseLog::info($request, json_encode($dados) );

        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => 'success',
            'text' => 'Cadastro realizado com sucesso.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $retEntity = $this->getModel()->findOrFail($id);
        $dadoAtual = $retEntity->toArray();

        $this->validaRoles($request, $retEntity);

        $dados = $request->all();

        if($this->validaSenha($dados['senha'], $dados['repeat_senha'])){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'danger',
                'text' => 'Senhas não conferem.'
            ]);
        }

        list($papeis, $sistemas) = $this->verificaPapeisSistema($dados);
        if(!is_array($papeis)){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'danger',
                'text' => 'Seleciona um perfil para o usuário.'
            ]);
        }

        $dados['papeis'] = $papeis;
        $dados['sistemas'] = $sistemas;
        if(!empty($dados['senha'])){
            $dados['password'] = Hash::make($dados['senha']);
        }

        $retEntity->atualizaUsuario($dados);

        $log = [
            'Atual' => $dadoAtual,
            'Novo' => $request->all()
        ];

        BaseLog::info($request, json_encode($log) );

        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => 'success',
            'text' => 'Registro editado com sucesso.'
        ]);
    }

    public function destroy($id)
    {
        try {
            $dados = $this->getModel()->findOrFail($id);

            $dados->papeisUsuario()->detach();
            $dados->sistemasUsuario()->detach();
            $dados->delete();

            BaseLog::info($this->request, 'Realizando Exclusão ID: '.$id);

            $mensagem = 'Exclusão realizada com sucesso.';
            $type = 'success';

        } catch (\Exception $th) {
            $mensagem = 'Ocorreu um erro ao excluir o registro. Verifique se o registro não possui vinculos.';
            $type = 'danger';
        }

        return $this->getResponseJson(['message' => $mensagem, 'type' => $type]);
    }

    public function configuracaoShow()
    {
        return view($this->getRota().".config");
    }

    public function atualizaSenha(Request $request)
    {
        /** @var \Modules\Seguranca\Models\Usuarios $usuario */
        $usuario = Auth::user();
        $dados = $request->all();

        if(!Hash::check($dados['senhaAtual'], $usuario->password)){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'danger',
                'text' => 'Senha atual não confere.'
            ]);
        }

        if($this->validaSenha($dados['senha'], $dados['repeat_senha'])){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => 'danger',
                'text' => 'Senhas não conferem.'
            ]);
        }

        $usuario->update(
            [
                'password' => Hash::make($dados['senha'])
            ]
        );

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Senha atualizada com sucesso.'
        ]);;
    }

    protected function getAttributesView()
    {
        $modPapeis = new Papeis();
        $papeis = $modPapeis
            ->orderBy('papel_nome','ASC')
            ->get(['papel_nome','papel_id'])
            ->pluck('papel_nome', 'papel_id')
            ->toArray();

        return [
            'papeis' => $papeis
        ];
    }

    /** Valida login pode ser usado */
    public function validaLogin(Request $request)
    {
        $login = $request->input('login');

        if(!$login){
            return $this->getResponseJson(['message' => 'Login não pode estar vazio', 'type' => 'danger']);
        }

        $usrModel = new Usuarios();
        $usr = !!$usrModel->where('usr_login', $login)->get()->count();

        return $this->getResponseJson(['login' => $usr]);

    }
   
}
