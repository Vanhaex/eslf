<?php

namespace Framework\Middlewares;

/**
 * Va ajouter les en-têtes HTTP prédéfinies
 */
class SetHeadersMiddleware
{
    /**
     * Lance ce qui va être executé par le Middleware
     *
     * @return void
     */
    public static function execute()
    {
        // Contient les en-tetes HTTP et leur valeur par défaut
        $headersArray = [
            "X-Frame-Options" => "SAMEORIGIN",
            "X-Content-Type-Options" => "nosniff",
            "X-XSS-Protection" => "1;mode=block",
            "Content-Type" => "text/html",
            "Access-Control-Allow-Origin" => "Deny",
            "X-Powered-By" => "ESLF Framework"
        ];

        foreach ($headersArray as $key => $value){
            header($key . ': ' . $value);
        }
    }
}