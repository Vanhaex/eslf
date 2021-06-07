<?php

namespace Framework;

/**
* Classe pour gérer le routage
**/
class Router
{
  /**
  * Tableau avec les données de chaque route
  **/
  private $routes = array();

  /**
  * Tableau avec le nom de la route
  **/
  private $routes_name = array();

  /**
  * Tableau avec l'URL de la route
  **/
  private $routes_path = array();

  /**
  * Tableau avec le controller de la route
  **/
  private $routes_controller = array();

  /**
  * Tableau avec le ID de la route
  **/
  private $routes_method = array();

  /**
  * Compteur de routes qui est incrémenté à chaque nouvelle route. Commence à 0 par défaut
  **/
  private $id_routes = 0;

  /**
  * Valeur booléene qui permet de rediriger vers une page spécifique en cas d'erreur 404
  **/
  private $error_404 = false;

  /**
  * Initialiser une route
  **/
  public function initRoute($routeName, $url_path, $controller, $method)
  {
    // On remplit les attributs de la classe par des tableaux associatifs qui correspondent à l'id d'une route
    $this->routes_name[$routeName] = $this->id_routes;
    $this->routes_path[$url_path] = $this->id_routes;
    $this->routes_controller[$controller] = $this->id_routes;
    $this->$routes_method[$method] = $this->id_routes;

    // On remplit le tableau avec comme clef l'id de la route et comme valeurs l'URL, le controller, l'action etc...
    $this->routes[$this->id_routes] = array("name" => $routeName, "path" => $url_path, "controller" => $controller, "method" => $method);

    // On incremente donc à chaque nouvelle route
    $this->id_routes++;
  }

  /**
  * Retourne l'URL si elle existe
  **/
  public function getURL($routeName)
  {
    if (array_key_exists($routeName, $this->routes_name)) {
      return "/" . $this->routes[$this->routes_name[$routeName]]["path"];
    }
    // ...Sinon, on redirige vers l'accueil ! (ou autre page par défaut)
    else {
      return "";
    }
  }

  /**
  * Retourne le controller et la méthode correspondantes si elles existent
  **/
  public function getController($url_path)
  {
    if (array_key_exists($url_path, $this->routes_path)) {
      return array($this->routes[$this->routes_path[$url_path]]["controller"], $this->routes[$this->routes_path[$url_path]]["method"]);
    }
    // Si l'URL n'existe pas, donc erreur 404 et on redirige vers le template prévu pour
    else {
      return $this->error_404 = true;
    }
  }

  /**
  * Redirige vers un template en cas d'erreur 404
  **/
  public function error404()
  {
    if ($this->error_404 == true) {
      return true
    }
    return false;
  }
}

?>
