<?php

namespace Framework\Command;

class StatusCommandHandler
{
    public static function success($text)
    {
        echo self::writeOutput($text, "success");
    }

    public static function error($text)
    {
        echo self::writeOutput($text, "error");
    }

    public static function warning($text)
    {
        echo self::writeOutput($text, "warning");
    }

    private static function writeOutput($text, $type)
    {
        $ouputcmd = null;

        if ($type == "success"){
            $ouputcmd = "\n\e[32m".trim($text)."\e[0m\n\n";
        }
        elseif ($type == "error"){
            $ouputcmd = "\n\e[31m".trim($text)."\e[0m\n\n";
        }
        elseif ($type == "warning"){
            $ouputcmd = "\n\e[33m".trim($text)."\e[0m\n\n";
        }

        return $ouputcmd;
    }
}