<?php

namespace Framework;

require_once('../config/app.config.php');

class LogWriting
{
  private $filename;
  private $message;
  private $level;

  // Tableau contenant les différents niveaux de log
  private $loglevel = array(
    'ALERT',
    'ERROR',
    'WARNING',
    'DEBUG',
    'INFO'
  );

  public function __construct($filename, $level, $message)
  {
    // assurons nous que le niveau de log ainsi que le message existent
    if(!in_array($level, $this->loglevel) || is_null($message)) {
      return false;
    }
    else {
      $message = $message . " \n";
      error_log("[ESLF][". date("Y-m-d H:i:s") ."][". $level ."] ".$message, 3, LOG_FILE_PATH . $filename);
    }
  }
}

?>
