<?php

namespace Framework;

use Framework\RouteException;

class Route {

    private $path;
    private $controller;
    private $method;

    private $matches = [];

    public function __construct($path, $controller, $method)
    {
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
    * Permettra de capturer l'url avec les paramètre
    * get('/posts/:slug-:id') par exemple
    **/
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        return true;
    }

    public function call()
    {
      ob_start();

      $method = trim($this->method);

      if(substr($this->controller, 0,1) != '\\'){
        $controller = 'App\\' . $this->controller;
      }

      if (class_exists($controller)) {
        $controller = new $controller();

        if (method_exists($controller, $method)) {
          call_user_func_array(array($controller, $method), $this->matches);
        }
        else {
          return RouteException;
        }
      }

      $rendered_page = ob_get_contents();

      ob_end_clean();

      return $rendered_page;
    }

}


?>
