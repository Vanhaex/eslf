<?php

namespace Framework;

use Config\AppConfig;

class ApiException extends \Exception
{
    public function __construct($message = "", $code = 0, \Exception $exception = null)
    {
        if (AppConfig::getDebug()){
            parent::__construct($message, $code, $exception);

            echo "Erreur API ".$code." : " . $message . " " . $exception;
        }
    }
}