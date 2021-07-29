<?php

namespace Framework;

/**
* Classe qui permet de récupérer les informations sur le serveur
**/
class ServerUtility
{
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
}



?>
