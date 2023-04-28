<?php

namespace Framework;

use Config\AppConfig;

class LogWriting
{
    private $filename;
    private $message;
    private $level;

    // Array with log levels
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
     * Write log message
     *
     * @param $filename string the filename
     * @param $level string log level, only in the array
     * @param $message string message to show
     * @return false|void
     */
    public function write(string $filename, string $level, string $message)
    {
        // Be sure that log level and message is given in arguments
        if($level && $message && $filename) {

            // Return message if error
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
                // Let's write log with private methods that will sanitize and verify what we add in parameter
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

            // Let's create folder named in global variable if it don't exist and add path to him
            $filename = $this->setDirectory($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . AppConfig::getLogFilePath() . DIRECTORY_SEPARATOR ) . $filename;

            // We create it to be sure
            if (!file_exists($filename)){
                file_put_contents($filename, "");
            }
            else {
                // Max 10 Mo, we create a new log file
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