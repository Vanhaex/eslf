<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
  set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};

// Autoloader
require_once("../vendor/autoload.php");

// Smarty Class
require_once("../vendor/smarty/smarty/libs/Smarty.class.php");


// Initialisation des headers HTTP
use Framework\Middlewares\Middleware;


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
// Middleware::process("FooBar");


use Framework\Router;
use Framework\SessionUtility;

$smarty = new Smarty();

try
{
  $router = new Router();

  include("../config/routes.config.php");
  include("../config/app.config.php");

  if (CONFIG_DEBUG == "true") {
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL & ~E_NOTICE); // Toutes les erreurs sauf le level "Notice"
  }

  $session = SessionUtility::getInstance();

  $render = $router->run();
  echo $render;
}
catch(\Framework\RouteException $e)
{
  header("HTTP/1.1 404 Not Found");
  $smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);
  $smarty->display($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "errors" . DIRECTORY_SEPARATOR . "404.tpl");
}
catch(Exception $e)
{
  header("HTTP/1.1 505 Internal Server Error");
  $smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);

  // Affichage du message si erreur 500
  if (CONFIG_DEBUG == "true") {
    $smarty->assign('detail_exception', 'Détails de l\'erreur : ' . $e->getFile() . ':' . $e->getLine() . '<br>' . $e->getMessage());
  }
  $smarty->display($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "errors" . DIRECTORY_SEPARATOR . "500.tpl");
}

?>
