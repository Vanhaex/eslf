<?php

namespace Framework;

use Smarty;
use Framework\ESDBaccess;

require('../config/app.config.php');
require('../config/database.config.php');

abstract class Controller
{

  protected $smarty;
  protected $esdbaccess;

  public function __construct()
  {
    // on instancie les variables pour les réutiliser dans les controlleurs
    $this->esdbaccess = $this->initDatabase();

    if (is_null($this->smarty)) {
        $this->smarty = new Smarty();
        // Configuration de Smarty
        $this->smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'views' .  DIRECTORY_SEPARATOR);
        $this->smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);
        $this->smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'cache' . DIRECTORY_SEPARATOR);
        if (CONFIG_DEBUG == "true") {
          $this->smarty->cache_lifetime = 0;
          $this->smarty->setCaching(Smarty::CACHING_OFF);
        }
        else {
          $this->smarty->cache_lifetime = 0;
          $this->smarty->setCaching(Smarty::CACHING_OFF);
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

  public function initDatabase()
  {
    $this->esdbaccess = new ESDBaccess\ESDBaccess(CONFIG_DATABASE_HOST, CONFIG_DATABASE_USER, CONFIG_DATABASE_PASSWORD, CONFIG_DATABASE_DATABASE, CONFIG_DATABASE_PORT);
    $this->esdbaccess->connectToDB();

    return $this->esdbaccess;
  }

}

?>
