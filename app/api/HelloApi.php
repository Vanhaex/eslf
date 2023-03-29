<?php

namespace App\api;

use Framework\ApiUtility;

/**
 * <p><b>Nom :</b> HelloApi</p>
 * <p><b>Description :</b> Un test qui renvoie juste un hello au format JSON</p>
 * <p><b>URI :</b> /api/hello</p>
 *
 */
class HelloApi extends ApiUtility
{
    public function index(): string
    {
        return "Hello World from HelloApi !";
    }
}

?>