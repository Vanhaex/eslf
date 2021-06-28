<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
  set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};

// Header
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1;mode=block");
header("Content-Type: text/html");
header("Access-Control-Allow-Origin: *");

ini_set("session.cookie_httponly", 1);

ini_set("session.use_only_cookies", 1);

// Autoloader
require_once("../vendor/autoload.php");

use Framework\Router;
use Framework\Controller;

try
{
  $router = new Router();

  include("../config/routes.config.php");

  $render = $router->run();
  echo $render;
}
catch(\Framework\RouteException $e)
{
  header("HTTP/1.1 404 Not Found");
  echo "ERREUR 404"; // Temporaire, on va trouver des alternatives pour afficher une page prévue à cet effet
}
catch(\Exception $e)
{
  header("HTTP/1.1 505 Internal Server Error");
  echo "ERREUR 505"; // Temporaire, on va trouver des alternatives pour afficher une page prévue à cet effet
}




?>
