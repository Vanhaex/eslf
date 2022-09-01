<?php

namespace App\api;

use Framework\ApiUtility;
use Framework\InputUtility;
use Symfony\Component\Console\Input\Input;

/**
 * <p>Nom : HelloApi</p>
 * <p>Description : Un test qui renvoie juste un hello au format JSON</p>
 * <p>URI : /api/hello</p>
 *
 */
class HelloApi extends ApiUtility
{
    public function index()
    {
        $array = $this->getParam();

        return "Bonjour je m'appelle " . $array[0] . " !";
    }
}