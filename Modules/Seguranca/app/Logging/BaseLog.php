<?php

namespace Modules\Seguranca\Logging;

use Illuminate\Http\Request;
use Modules\Seguranca\Logging\Logging;

class BaseLog
{

    /**
     * Cadastrar mensagem log do tipo emergencial
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function emergency(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'emergency', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo alerta
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function alert(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'alert', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo critico
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function critical(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'critical', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo erro
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function error(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'error', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo aviso
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function warning(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'warning', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo aviso previo
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function notice(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'notice', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo informação
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function info(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'info', $mensagem);
    }

    /**
     * Cadastrar mensagem log do tipo depuração
     *
     * @param Request $request
     * @param string $mensagem
     * @return void
     */
    public static function debug(Request $request, $mensagem)
    {
        $logging = new Logging();
        $logging->saveLog($request, 'debug', $mensagem);
    }

}
