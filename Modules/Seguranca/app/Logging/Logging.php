<?php

namespace Modules\Seguranca\Logging;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logging
{
    /**
     * Metodo utilizado para salvar logs no sistema
     *
     * @param  string  $tipo
     * @param  string  $messagem
     * @return void
     */
    public function saveLog(Request $request, $tipo, $messagem)
    {
        try {
            $actionRoute = $request->route()->getAction();
            [$controller, $action] = explode('@', $actionRoute['controller']);

            $data = [
                'log_controller' => $controller,
                'log_action' => $action,
                'log_nome_rota' => $request->route()->getName(),
                'log_tipo' => $tipo,
                'log_msg' => $messagem,
            ];

            Auth::user()->logs()->create($data);
        } catch (\Exception $e) {
            // Silenciosamente ignora erros de logging (ex: durante testes)
            // onde o usuário pode não existir em seg_usuarios
        }
    }
}
