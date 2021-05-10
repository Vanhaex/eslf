<?php

namespace Framework;

private $file;
private $level;
private $message;

// Levels
private const CRITICAL = "CRITICAL";
private const ERROR = "ERROR";
private const WARNING = "WARNING";
private const INFO = "INFO";
private const DEBUG = "DEBUG";

/**
* Class for writing logs
*/
class LogWriting
{
  public function __construct(){}

  /**
  * Open File to write
  */
  public function getFile()
  {
    if (is_null($this->file)) {
      $this->file = dirname(__FILE__) . "/log/app.log";
      fopen($this->file, 'w');
    }
  }

  /**
  * Write in the opened file
  * @param string $level The level of the message created
  */
  public function writeLog($level, $message)
  {
    $this->getFile();
    $this->level = $level;
    $this->message = $message;

    if (isset($this->file)) {
      $info = "[" . date("d-m-Y H:i:s") . "][" . $level . "]" . $message
      fwrite($this->file, $info);
    }
    else {
      return false;
    }

    return true;
  }
}


 ?>
