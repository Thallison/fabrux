<?php

namespace Modules\Seguranca\Logging;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logging
{

    /**
     * Metodo utilizado para salvar logs no sistema
     *
     * @param Request $request
     * @param string $tipo
     * @param string $messagem
     * @return void
     */
    public function saveLog(Request $request, $tipo, $messagem)
    {
        $actionRoute = $request->route()->getAction();
        list($controller, $action) = explode('@', $actionRoute['controller']);

        $data = [
            'log_controller' => $controller,
            'log_action' => $action,
            'log_nome_rota' => $request->route()->getName(),
            'log_tipo' => $tipo,
            'log_msg' => $messagem
        ];

        Auth::user()->logs()->create($data);
    }
}
