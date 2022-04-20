<?php

namespace Framework;

class RouteException extends \Exception
{
    public function __construct($message = "", $code = 0, \Exception $exception = null)
    {
        parent::__construct($message, $code, $exception);

        echo "Erreur Route ".$code." : " . $message . " " . $exception;
    }
}


?>
