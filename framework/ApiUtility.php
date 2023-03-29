<?php

namespace Framework;

abstract class ApiUtility
{
    /**
     * Permets de retourner mes paramètres données dans l'api
     *
     * @param int $key le pointeur vers le paramètre à analyser (Exemple 0 => première occurrence)
     * @return false|mixed|string|string[]
     */
    protected function getParam(int $key = 0)
    {
        $url = InputUtility::request("server", "REQUEST_URI");

        $array_params = explode("/", $url);

        for ($i=0; $i < 3; $i++){
            unset($array_params[$i]);
        }

        $array_params = array_values($array_params);

        if ($key !== 0){
            return $array_params[$key];
        }

        return $array_params;
    }
}