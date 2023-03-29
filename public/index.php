<?php


/*
 * -------------------------------------------------------------
 * Racine du projet
 *
 * On ajoute la racine du projet (exemple : /var/www/eslf) au
 * répertoire d'inclusion PHP. Ce qui facilite l'inclusion des
 * fichiers sans avoir à chercher où il se trouve.
 * -------------------------------------------------------------
 */
$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};


// Autoloader, pour mieux gérer nos classes
require_once("vendor/autoload.php");

// Les use, qui vont nous être essentiels :)
use Framework\InputUtility;
use Framework\Middlewares\Middleware;
use Framework\Router;
use Framework\RouteException;
use Framework\SessionUtility;
use Framework\View;
use Config\AppConfig;
use Config\RoutesConfig;

$smarty = View::initView();
$session = SessionUtility::getInstance();

try
{
    /*
     * -------------------------------------------------------------
     * Mode debug
     *
     * Le mode debug est très pratique, il permet d'afficher les
     * messages d'erreurs PHP. Vous pouvez activer ou désactiver
     * ce mode en modifiation la valeur de la variable CONFIG_DEBUG
     * dans le fichier de config AppConfig.php. Assurez-vous de
     * le désactiver avant la mise en production !
     * -------------------------------------------------------------
     */
    if (AppConfig::getDebug() == "true") {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL); // Toutes les erreurs sauf le level "Notice"
    }

    /*
    * -------------------------------------------------------------
    * Middlewares
    *
    * On va appeler tous les middlewares que l'on a défini qui vont
    * traiter la requête qui a été soumise. Par exemple, les
    * middlewares par défaut vont ajouter les en-têtes HTTP standard
    * et la vérification du jeton CSRF.
    * Il est possible d'ajouter plus de middlewares
    * -------------------------------------------------------------
    */
    Middleware::process("SetHeaders");
    Middleware::process("VerifyCSRF");

    /*
    * -------------------------------------------------------------
    * Le routage
    *
    * On va appeler les classes qui s'occupent du routage.
    * Vous pouvez ajouter des routes dans le fichier de config
    * RoutesConfig.php. On sépare en deux les classes utilisées
    * en fonction de si c'est une API ou non
    * -------------------------------------------------------------
    */
    $router = new Router();
    $router = RoutesConfig::getRoutes($router);

    if (preg_match("/^(\\" . AppConfig::getApiBaseUri() . ")/im", InputUtility::request("server", "REQUEST_URI"))){
        $render = $router->runAPI();
    }
    else {
        $render = $router->run();
    }

    echo $render;
}
catch(RouteException $e)
{
    // En cas d'erreur 404, ce qui signifie que la page ou la ressource demandée n'a pas été trouvée !
    View::error404();
}
catch(Exception $e)
{
    // Ou en cas d'erreur 500, ce qui signifie qu'il y a un problème côté serveur (délai de réponse trop long, erreur dans l'execution d'un script, problème lié au serveur, etc...)
    // ici, on précise le message d'erreur pour comprendre
    View::error500($e->getFile() . ':' . $e->getLine() . '<br>' . $e->getMessage());
}

?>
