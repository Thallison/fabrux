<?php

namespace Modules\Base\Traits;

/**
 * Traits com metodos padrões para utilizar em todo sistema
 */
trait BaseUtils
{

    /**
     * Converte tempo(campo time html) para segundos
     */
    function tempoParaSegundos($time)
    {
        [$h, $m] = explode(':', $time);
        return ($h * 3600) + ($m * 60);
    }

    /**
     * Converte segundos para tempo
     */
    function segundosParaTime($segundos)
    {
        $horas = floor($segundos / 3600);
        $minutos = floor(($segundos % 3600) / 60);

        return sprintf('%02d:%02d', $horas, $minutos);
    }


}
