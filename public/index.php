<?php


/*
 * -------------------------------------------------------------
 * Racine du projet
 *
 * On ajoute la racine du projet (exemple : /var/www/eslf) au
 * répertoire d'inclusion PHP. Ce qui facilite l'inclusion des
 * fichiers sans  avoir à chercher où il se trouve.
 * -------------------------------------------------------------
 */
$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
  set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};

// Les variables globales doivent être définies
require_once("config/app.config.php");

// Autoloader, pour mieux gérer nos classes
require_once("vendor/autoload.php");

// Les use, qui vont nous être essentielles :)
use Framework\Middlewares\Middleware;
use Framework\Router;
use Framework\RouteException;
use Framework\SessionUtility;
use Framework\View;

$smarty = View::initView();
$session = SessionUtility::getInstance();

try
{
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
  //Middleware::process("FooBar");


  /*
   * -------------------------------------------------------------
   * Mode debug
   *
   * Le mode debug est très pratique, il permet d'afficher les
   * messages d'erreurs PHP. Vous pouvez activer ou désactiver
   * ce mode en modifiation la valeur de la variable CONFIG_DEBUG
   * dans le fichier de config app.config.php. Assurez-vous de
   * le désactiver avant la mise en production !
   * -------------------------------------------------------------
   */
  if (CONFIG_DEBUG == "true") {
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL & ~E_NOTICE); // Toutes les erreurs sauf le level "Notice"
  }

  /*
   * -------------------------------------------------------------
   * Le routage
   *
   * On va appeler les classes qui s'occupent du routage.
   * Vous pouvez ajouter des routes dans le fichier de config
   * routes.config.php.
   * -------------------------------------------------------------
   */
  $router = new Router();
  include("config/routes.config.php");
  $render = $router->run();
  echo $render;
}
// En cas d'erreur 404 !
catch(\Framework\RouteException $e)
{
  header("HTTP/1.1 404 Not Found");
  $smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);
  $smarty->display($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "errors" . DIRECTORY_SEPARATOR . "404.tpl");
}
// Ou en cas d'erreur 500 !
catch(Exception $e)
{
  header("HTTP/1.1 500 Internal Server Error");
  $smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);

  // Affichage du message si erreur 500
  if (CONFIG_DEBUG == "true") {
    $smarty->assign('detail_exception', 'Détails de l\'erreur : ' . $e->getFile() . ':' . $e->getLine() . '<br>' . $e->getMessage());
  }
  $smarty->display($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "errors" . DIRECTORY_SEPARATOR . "500.tpl");
}

?>
