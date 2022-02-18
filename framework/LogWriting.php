<?php

namespace Framework;

require_once('../config/app.config.php');

class LogWriting
{
  private $filename;
  private $message;
  private $level;

  // Tableau contenant les différents niveaux de log
  const LOGLEVEL = ['ALERT', 'ERROR', 'WARNING', 'DEBUG', 'INFO'];

  public function __construct($filename, $level, $message)
  {
    // assurons nous que le niveau de log ainsi que le message existent
    if($this->setFilename($filename) && $this->setMessage($message) && $this->setLevel($level)) {
      $message = $message . " \n";
      error_log("[ESLF][". date("Y-m-d H:i:s") ."][". $level ."] ".$message, 3, LOG_FILE_PATH . $filename);
    }
    else {
      return false;
    }
  }

  private function setFilename($filename)
  {
    if (!is_null($$filename)) {
      $this->filename = $filename;
    }
  }

  private function setLevel($level)
  {
    if (in_array($level, LogWriting::LOGLEVEL)){
      $this->level = $level;
    }
  }

  private function setMessage($message)
  {
    if (!is_null($message)) {
      $this->message = $message;
    }
  }

}

?>
