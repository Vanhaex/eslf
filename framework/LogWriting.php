<?php

namespace Framework;

use Config\AppConfig;

class LogWriting
{
  private $filename;
  private $message;
  private $level;

  // Tableau contenant les différents niveaux de log
  const LOGLEVEL =
      [
          'ALERT',
          'ERROR',
          'WARNING',
          'INFO',
          'DEBUG'
      ];

  public function __construct(){}

  /**
   * Ecrit un message de log
   *
   * @param $filename string le nom du fichier dans lequel on écrit
   * @param $level string le niveau de log, seulement ceux dans l'array LOGLEVEL
   * @param $message string le message que l'on souhaite voir afficher
   * @return false|void
   */
  public function write(string $filename, string $level, string $message)
  {
    // assurons nous que le niveau de log ainsi que le message existent
    if($level && $message && $filename) {


      // Message de retour en cas de problème
      if (!$this->setLevel($level)){
        echo "Erreur Log : Le niveau de log n'existe pas";
      }
      elseif (!$this->setMessage($message)){
        echo "Erreur Log : Le message de log est manquant";
      }
      elseif (!$this->setFile($filename)){
        echo "Erreur Log : Le fichier de log n'est pas accessible";
      }
      else {
        // On écrit donc le log grâce aux méthodes privées qui vont nettoyer et vérifier ce que l'on met en paramètre
        error_log("[ESLF][". date("Y-m-d H:i:s") ."][". $this->setLevel($level) ."] ".$this->setMessage($message), 3, $this->setFile($filename));
      }

    }
    else {
      return false;
    }
  }

  private function setFile($filename)
  {
    if (!empty($filename)) {

      // on va créer le dossier nommé dans la variable globale s'il n'existe pas avant et ajouter le chemin vers lui
      $filename = $this->setDirectory($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . AppConfig::getLogFilePath() . DIRECTORY_SEPARATOR ) . $filename;

      // On le créé s'il n'existe pas
      if (!file_exists($filename)){
        file_put_contents($filename, "");
      }
      else {
        // A 10Mo le fichier on le renomme avant d'en créer un nouveau
        if (filesize($filename) == 10240){
          rename($filename, $filename."-old");

          file_put_contents($filename, "");
        }
      }

      return $this->filename = $filename;
    }

    return false;
  }

  private function setLevel($level)
  {
    if (in_array($level, LogWriting::LOGLEVEL)){
      return $this->level = $level;
    }

    return false;
  }

  private function setMessage($message)
  {
    if (!empty($message)) {
      $message = trim(htmlspecialchars($message));
      $message .= " \n";
      return $this->message = $message;
    }

    return false;
  }

  private function setDirectory($dir)
  {
    if (!file_exists($dir)){
      mkdir($dir, 0775, true);
    }

    return $dir;
  }
}

?>
