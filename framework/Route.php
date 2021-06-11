<?php 

namespace Framework;

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
  
}


?>
