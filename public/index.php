<?php


/*
 * -------------------------------------------------------------
 * Project root
 *
 * We add the project root (example: /var/www/eslf) to the PHP
 * include directory. This makes it easier to include files
 * without having to search for their location
 * -------------------------------------------------------------
 */
$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (!stristr($path, $current_include_path)) {
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};


// Autoloader, to automatically load our classes
require_once("vendor/autoload.php");

// We call the necessary classes for using our methods in this index file
use Framework\Middlewares\Middleware;
use Framework\Router;
use Framework\RouteException;
use Framework\SessionUtility;
use Framework\InputUtility;
use Framework\View;
use Config\AppConfig;
use Config\RoutesConfig;

$smarty = View::initView();
$session = SessionUtility::getInstance();

try
{
    /*
     * -------------------------------------------------------------
     * Debug mode
     *
     * The debug mode is very useful, it allows displaying PHP error
     * messages. You can activate or deactivate this mode by modifying
     * the value of the 'CONFIG_DEBUG' variable in the AppConfig.php
     * configuration file. Make sure to disable it before production
     * deployment!
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
    * We will call all the middlewares we have defined that will
    * handle the submitted request. For example, the default
    * middlewares will add standard HTTP headers and CSRF token
    * verification. It is possible to add more middlewares.
    * -------------------------------------------------------------
    */
    Middleware::process("SetHeaders");
    Middleware::process("VerifyCSRF");

    /*
    * -------------------------------------------------------------
    * Routing
    *
    * We will call the classes that handle routing. You can add
    * routes in the RoutesConfig.php configuration file. We
    * separate the classes used depending on whether it is an API
    * or not.
    * -------------------------------------------------------------
    */
    $router = new Router();
    $router = RoutesConfig::getRoutes($router);

    if (preg_match("/^(\\" . AppConfig::getApiBaseUri() . ")/im", InputUtility::server("REQUEST_URI"))){
        $render = $router->runAPI();
    }
    else {
        $render = $router->run();
    }

    echo $render;
}
catch(RouteException $e)
{
    // In case of a 404 error, which means that the requested page or resource was not found !
    View::error404();
}
catch(Exception $e)
{
    // Or in case of a 500 error, which means that there is a problem on the server side (response time too long, error in executing a script, server-related issue, etc.)
    // Here, we specify the error message for better understanding.
    View::error500($e->getFile() . ':' . $e->getLine() . '<br>' . $e->getMessage());
}

?>
