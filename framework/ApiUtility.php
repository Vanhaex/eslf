<?php

namespace Framework;

use Config\AppConfig;

abstract class ApiUtility
{
    /**
     * Permets de retourner mes paramètres données dans l'api
     *
     * @param string $key le pointeur vers le paramètre à analyser (Exemple 0 => première occurence)
     * @return false|mixed|string|string[]
     */
    protected function getParam(string $key = "")
    {
        $url = InputUtility::server("REQUEST_URI");

        $array_params = explode("/", $url);

        for ($i=0; $i < 3; $i++){
            unset($array_params[$i]);
        }

        $array_params = array_values($array_params);

        if ($key !== ""){
            return $array_params[$key];
        }

        return $array_params;
    }
}