<?php

namespace Framework;

/**
* Classe qui permet de récupérer des données par HTTP (GET ou POST) puis effectuer divers traitements
**/
class InputUtility
{

  /**
  * Indique si les méthodes PUT et DELETE doivent être réécrites en POST
  * Peut être nécessaire pour les API REST qui ne supportent pas ces methodes
  *
  **/
  const OVERRIDE = 'HTTP_X_HTTP_METHOD_OVERRIDE';

  /**
  * Un array content les termes qui doivent être exclus pour éviter l'injection SQL
  *
  * @var array
  **/
  const INJECTION_PROTECTION_KEY = [
            "insert", "select", "from",
            "where", "drop", "into",
            "open", "parameter", ";",
            "update", "close", "connect",
            "<script>", "database", "delete",
            "substring" ];

  /**
  * Prévient des injections SQL et noSQL
  *
  * @param string $value          La valeur du tableau associatif ($_GET, $_POST, etc...)
  * @param string $defaultValue   Une valeur par défaut
  **/
  protected static function preventInjection($value, $defaultValue)
  {
    if (isset($value)) {
      $value = str_replace(InputUtility::INJECTION_PROTECTION_KEY, '', $value);
      return htmlspecialchars($value, ENT_QUOTES);
    }
    else {
      return $defaultValue;
    }
  }


  /**
  * Récupère la valeur du tableau $_GET
  *
  * @param string $key       La valeur clée du tableau
  * @param string $default   La valeur par défaut
  **/
  public static function get($key = null, $default = null)
  {
    return static::preventInjection($_GET[$key], $default);
  }

  /**
  * Récupère la valeur du tableau $_POST
  *
  * @param string $key       La valeur clée du tableau
  * @param string $default   La valeur par défaut
  **/
  public static function post($key = null, $default = null)
  {
    return static::preventInjection($_POST[$key], $default);
  }

  /**
  * Récupère la valeur du tableau $_FILES
  *
  * @param string $key       La valeur clée du tableau
  * @param string $type      Le type de donnée associé au fichier (nom, taille, etc...)
  * @param string $default   La valeur par défaut
  **/
  public static function file($key = null, $type = null, $default = null)
  {
    return static::preventInjection($_FILES[$key][$type], $default);
  }

  /**
  * Récupère la valeur du tableau $_SESSION
  *
  * @param string $key       La valeur clée du tableau
  * @param string $default   La valeur par défaut
  **/
  public static function session($key = null, $default = null)
  {
    return static::preventInjection($_SESSION[$key], $default);
  }

  /**
  * Récupère la valeur du tableau $_COOKIE
  *
  * @param string $key       La valeur clée du tableau
  * @param string $default   La valeur par défaut
  **/
  public static function cookie($key = null, $default = null)
  {
    return static::preventInjection($_COOKIE[$key], $default);
  }

  /**
  * Récupère la valeur du tableau $_ENV
  *
  * @param string $key       La valeur clée du tableau
  * @param string $default   La valeur par défaut
  **/
  public static function env($key = null, $default = null)
  {
    return static::preventInjection($_ENV[$key], $default);
  }

  /**
  * Indique la méthode utilisée dans al requête (GET, POST, PUT, etc...)
  * On vérifie si les requêtes PUT et DELETE son réécrites en POST
  *
  **/
  public static function request_method()
  {
    $req_method = $_SERVER['REQUEST_METHOD'];

    return strtoupper($req_method);
  }

  /**
  * Méthode qui vérifie si l'URI est propre
  *
  **/
  public static function clean_uri(){
    $path = trim(static::server('REQUEST_URI'));

    if(substr($path, -1) == '/' && strlen($path) > 1) {
        $path = substr($path, 0, -1);
    }

    if(strncmp($path, '/index.php', 10) == 0){
        $path = '/';
    }

    return $path;
  }

}


?>
