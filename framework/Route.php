<?php

namespace Framework;

use Framework\RouteException;

class Route {

    private $path;
    private $controller;
    private $method;

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
        $regexp_path = preg_replace('#:[a-z-_]+#', '([a-zA-Z0-9\-\_\/]+)', $this->path);
        $result = preg_match('#^' . $regexp_path . '$#', $url, $matches);
        array_splice($matches, 0, 1);
        if($result == 1){
          return $matches;
        }

        return false;
    }

    public function call($param)
    {
      ob_start();

      $method = trim($this->method);

      if(substr($this->controller, 0,1) != '\\'){
        $controller = 'App\\' . $this->controller;
      }

      if (class_exists($controller)) {
        $controller = new $controller();

        if (method_exists($controller, $method)) {
          call_user_func_array(array($controller, $method), $param);
        }
        else {
          throw new RouteException;
        }
      }
      else {
        throw new RouteException;
      }

      $rendered_page = ob_get_contents();

      ob_end_clean();

      return $rendered_page;
    }

}


?>
