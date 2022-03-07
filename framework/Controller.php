<?php

namespace Framework;

use ESDBaccess\ESDBaccess;

require('../config/database.config.php');

abstract class Controller
{

  protected $smarty;
  protected $esdbaccess;

  public function __construct()
  {
    // on instancie les variables pour les réutiliser dans les controlleurs
    $this->esdbaccess = $this->initDatabase();
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

  public function initDatabase()
  {
    $this->esdbaccess = new ESDBaccess(CONFIG_DATABASE_HOST, CONFIG_DATABASE_USER, CONFIG_DATABASE_PASSWORD, CONFIG_DATABASE_DATABASE, CONFIG_DATABASE_PORT);
    $this->esdbaccess->connectToDB();
    $this->esdbaccess->ESDBautocommit(true);

    return $this->esdbaccess;
  }

}

?>
