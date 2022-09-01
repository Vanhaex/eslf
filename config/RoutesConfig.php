<?php

namespace Config;

use Framework\Router;

class RoutesConfig
{
    /**
     * Retoure toutes les routes disponibles
     *
     * @param Router $router
     * @return Router
     */
    public static function getRoutes(Router $router)
    {
        $router->get('/', 'HomeController', 'index');
        //
        // Exemple : $router->get('/bonjour', "MonControlleur", "MaMéthode");
        //
        // Si c'est une méthode POST, PUT ou DELETE, ajoutez '$router->post(...)'
        //
        // Pour les api, il faut préciser l'uri de base pour appeler les apis ('/api' par défaut) et préciser la méthode
        // Exemple : $router->api('/api/hello', 'GET');
        //
        $router->api('/api/hello', 'GET');

        return $router;
    }
}

?>
