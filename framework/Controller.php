<?php

namespace Framework;

use Config\AppConfig;
use Config\DatabaseConfig;
use ESDBaccess\ESDBaccess;

abstract class Controller
{

  protected $smarty;
  protected $esdbaccess;
  protected $log;

  public function __construct()
  {
    // on instancie les variables pour les réutiliser dans les controlleurs
    // Si on a besoin de se connecter à une bdd, on instancie l'objet
    if (AppConfig::getActivateDatabase() == true){
      $this->esdbaccess = $this->initDatabase();
    }

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

  public function initDatabase()
  {
    $this->esdbaccess = new ESDBaccess(DatabaseConfig::getDatabaseHost(), DatabaseConfig::getDatabaseUser(), DatabaseConfig::getDatabasePassword(), DatabaseConfig::getDatabaseDbName(), DatabaseConfig::getDatabasePort());
    $this->esdbaccess->connectToDB();
    $this->esdbaccess->ESDBautocommit(DatabaseConfig::getDatabaseTransactionMode());

    return $this->esdbaccess;
  }

}

?>
