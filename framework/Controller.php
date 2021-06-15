<?php

namespace Framework;

require_once('libs/Smarty.class.php');

use Smarty;

abstract class Controller
{

  protected $smarty;

  public function getSmarty()
  {
    if (is_null($this->smarty)) {
        $this->smarty = new Smarty();
        // Configuration de Smarty
        $this->smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'views' .  DIRECTORY_SEPARATOR);
        $this->smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);
        $this->smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'cache' . DIRECTORY_SEPARATOR);
        $this->smarty->debugging = true;
    }
    else {
      var_dump("HELLO VIEW");
    }

    return $this->smarty;
  }

  protected function view($template, $assign_value = null)
  {

    if (!is_null($assign_value)) {
      foreach ($assign_value as $key => $value) {
        $this->smarty->assign($key, $value);
      }
    }

    $this->smarty->display($template);
  }

  protected function redirect($path, $http_return_code)
  {
    if (is_null($http_return_code)) {
      $http_return_code = 200;
    }
    http_response_code($http_return_code);
    header('Location: ' . $path);
    exit();
  }
}

?>
