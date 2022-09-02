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

        return $router;
    }
}

?>
