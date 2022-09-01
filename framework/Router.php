<?php

namespace Framework;

class Router
{

    private $path; // Contiendra l'URL sur laquelle on souhaite se rendre
    private $routes = ['GET' => [], 'POST' => []];

    public function __construct(){}

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

    public function api($path, $method)
    {
        $route = new ApiController($path, $method);
        $this->routes[$method][] = $route;
        return $route; // On retourne la sortie de l'API
    }

    private function execute_route($request_method, $url)
    {
        if (in_array($request_method, ['GET', 'POST'])) {
            $existing_routes = $this->routes[$request_method];
            foreach ($existing_routes as $route) {
                $result = $route->match($url);
                if (is_array($result) == false)
                {
                    continue;
                }
                return $route->call($result);
            }
        }

        throw new RouteException;
    }

    public function run()
    {
        $req_method = InputUtility::request_method();
        $clean_path = InputUtility::clean_uri();

        // On a vérifié la méthode utilisée et l'URI est propre
        return $this->execute_route($req_method, $clean_path);
    }

    public function runAPI()
    {
        $req_method = InputUtility::request_method();
        $clean_path = InputUtility::clean_uri();

        $routeApi = new ApiController($clean_path, $req_method);
        $param = $routeApi->matchParameters($clean_path);
        return $routeApi->getAPI($param);
    }

}


?>
