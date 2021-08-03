<?php

namespace Framework;

use Smarty;

require('../config/app.config.php');

abstract class Controller
{

  protected $smarty;
  protected $database;

  public function __construct()
  {
    if (is_null($this->smarty)) {
        $this->smarty = new Smarty();
        // Configuration de Smarty
        $this->smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'views' .  DIRECTORY_SEPARATOR);
        $this->smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);
        $this->smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'cache' . DIRECTORY_SEPARATOR);
        if (CONFIG_DEBUG == "true") {
          $this->smarty->debugging = true;
        }
        else {
          $this->smarty->debugging = false;
        }

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

  public function redirect($path, $http_return_code)
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
