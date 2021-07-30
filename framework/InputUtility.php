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
  * Récupère la valeur du tableau $_SERVER
  *
  * @param string $key       La valeur clée du tableau
  * @param string $default   La valeur par défaut
  **/
  public static function server($key = null, $default = null)
  {
    return static::preventInjection($_SERVER[$key], $default);
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
  * Retourne le protocole HTTP de la requête
  **/
  public static function serverProtocol()
  {
    if (static::server('SERVER_PROTOCOL') !== null) {
      $server = static::server('SERVER_PROTOCOL');
      return $server;
    }
    else {
      $server = "HTTP/1.1";
      return $server;
    }
  }

  /**
  * Retourne "TRUE" si la requête a été éxecutée en HTTPS
  **/
  public static function isHttps()
  {
    if (strtoupper(static::server('HTTPS')) == "ON") {
      return true;
    }
  }

  /**
  * Retourne l'adresse IP de la machine client.
  * Si elle ne peut être obtenue, l'adresse sera 0.0.0.0
  **/
  public static function ip()
  {
    if (static::server('HTTP_CLIENT_IP') !== null) {
      $ips[] = static::server('HTTP_CLIENT_IP');
      // on va filter l'IP de la machine client afin de vérifier si c'est bien une adresse IP
      foreach ($ips as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 || FILTER_FLAG_IPV6 || FILTER_FLAG_NO_PRIV_RANGE || FILTER_FLAG_NO_RES_RANGE)) {
          return $ip;
        }
      }
    }
    else {
      return static::server('REMOTE_ADDR', '0.0.0.0');
    }
  }

  /**
  * Retourne le port utilisé pour les communications.
  * Si il ne peut être obtenu, le port sera 80
  **/
  public static function port()
  {
    if (static::server('SERVER_PORT') !== null) {
      return static::server('SERVER_PORT');
    }
    else {
      $default = "80";
      return $default;
    }
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
