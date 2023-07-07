<?php

namespace Config;

use Framework\Router;

class RoutesConfig
{
    /**
     * Return all available routes
     *
     * @param Router $router
     * @return Router
     */
    public static function getRoutes(Router $router): Router
    {
        $router->get('/', 'HomeController', 'index');
        //
        // Example : $router->get('/hello', "MyController", "MyMethod");
        //
        // If that's POST, PUT or DELETE, add '$router->post(...)'
        //

        return $router;
    }
}

?>