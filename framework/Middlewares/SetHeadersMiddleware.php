<?php

namespace Framework\Middlewares;

/**
 * Adding HTTP header for the queries
 */
class SetHeadersMiddleware
{
    /**
     * Launch what will be executed by the Middleware
     *
     * @return void
     */
    public static function execute()
    {
        // Contains HTTP headers and their default value
        $headersArray = [
            "X-Frame-Options" => "SAMEORIGIN",
            "X-Content-Type-Options" => "nosniff",
            "X-XSS-Protection" => "1;mode=block",
            "Content-Type" => "text/html",
            "Access-Control-Allow-Origin" => "Deny",
        ];

        foreach ($headersArray as $key => $value){
            header($key . ': ' . $value);
        }

        // Let's remove 'X-Powered-By'.
        header_remove("X-Powered-By");
    }
}