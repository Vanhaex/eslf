<?php

namespace Framework;

use Framework\Route;
use Framework\RouteException;

class Router
{

    private $path; // Contiendra l'URL sur laquelle on souhaite se rendre
    private $routes = []; // Contiendra la liste des routes

    public function get($path, $controller, $method)
    {
      $route = new Route($path, $controller, $method);
      $this->routes["GET"][] = $route;
      return $route; // On retourne la route pour "enchainer" les méthodes
    }

    public function post($path, $controller, $method)
    {
      $route = new Route($path, $controller, $method);
      $this->routes["POST"][] = $route;
      return $route; // On retourne la route pour "enchainer" les méthodes
    }

    public function run()
    {
      if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
          throw new RouteException('REQUEST_METHOD est inexistante');
      }
      foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
          if($route->match($this->path)){
              return $route->call();
          }
      }
      throw new RouteException('Aucune route');
    }

}


?>
