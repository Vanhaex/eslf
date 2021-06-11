<?php 

namespace Framework;

<<<<<<< HEAD
class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
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
      return call_user_func_array($this->callable, $this->matches);
    }

=======
class Route
{
  private $path;
  private $controller;
  private $method;

  private $matches = [];
  private $params = [];

  public function __construct($path, $controller, $method)
  {
    $this->path = trim($path, '/');
    $this->controller = $controller;
    $this->method = $method;
  }

  public function match($path)
  {
    // Remplacer les variables avec une regex
    $regex_variable = preg_replace('#:[a-z-_]+#', '([a-zA-Z0-9\-\_\/]+)', $this->path);

    // Cherchons les variables
    $regex_result = preg_match('#^' . $regexp_path . '$#', $path, $matches);

    // Removing the first value of the $matches cause it's not a match
    array_splice($matches, 0, 1);

    if($result == 1){
      return $matches;
    }

  }

  public function call()
  {
    ob_start();

    ob_start();

      $script_array = explode('@', $this->script);

      if(count($script_array) != 2){
          throw new NotFoundException();
      }

      $controller = $script_array[0];
      $action = $script_array[1];

      if(substr($controller, 0,1) != '\\'){
          $controller = '\Application\Controllers\\'.$controller;
      }

      if(class_exists($controller)){
          $object = new $controller();

          if(method_exists($object, $action)){
              call_user_func_array(array($object, $action), $params);
          }else{
              throw new NotFoundException();
          }
      }
      else{
          throw new NotFoundException();
      }

      $rendered_page = ob_get_contents();
      ob_end_clean();

      return $rendered_page;

  }
  
>>>>>>> f1e7a93fc64e122aad1307ce656c901ada9d02ba
}


?>
