<?php 


namespace Framework;

class Router
{
	private $path;

	private $routes = ['GET', 'POST'];

	public function get($path, $controller, $method)
	{
		array_push($this->routes['GET'], new Route($path, $controller, $method));
	}

	public function post($path, $controller, $method)
	{
		array_push($this->routes['POST'], new Route($path, $controller, $method));
	}

	public function run()
	{
		if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
        throw new RouteException();
    }
		foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
        if($route->match($this->url)){
            return $route->call();
        }
    }

		throw new RouteException();
	}
}


?>
