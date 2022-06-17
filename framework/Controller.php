<?php

namespace Framework;

use Config\AppConfig;

abstract class Controller
{

  protected $smarty;
  protected $log;

  public function __construct()
  {
    if (AppConfig::getActivateLogs() == true){
      $this->log = new LogWriting();
    }

    // On initialise Smarty (cache, dossier des plugins, etc...)
    $this->smarty = View::initView();
  }

  public function view($template, $assign_value = null)
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
