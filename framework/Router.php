<?php

namespace Framework;

use Framework\InputUtility;
use Framework\RouteException;

/**
* Classe pour gérer le routage
**/
class Router
{
  /**
  * L'URL sur laquelle on aimerait se rendre
  **/
  private $url;

  /**
  * La liste des routes
  **/
  private $routes = [];

  public function __construct($url)
  {
    $this->url = $url;
  }

  public function get($path, $callable)
  {
    $route = new Route($path, $callable);
    $this->routes["GET"][] = $route;
    return $route; // On retourne la route
  }

  public function run()
  {
    if (InputUtility::server('REQUEST_METHOD')) {
      throw new RouteException('La méthode REQUEST_METHOD est inexistante.');
    }
    foreach ($this->routes[InputUtility::server('REQUEST_METHOD')] as $route) {
      if ($route->match($this->url)) {
        return $route->call();
      }
    }

    throw new RouteException('Aucune route existante.');
  }
}

?>
