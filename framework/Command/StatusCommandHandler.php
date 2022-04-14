<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommandHandler
{
    public static function success($text, OutputInterface $output)
    {
        return self::writeOutput($text, "success", $output);
    }

    public static function error($text, OutputInterface $output)
    {
        return self::writeOutput($text, "error", $output);
    }

    public static function warning($text, OutputInterface $output)
    {
        return self::writeOutput($text, "warning", $output);
    }

    private static function writeOutput($text, $type, OutputInterface $output)
    {
        $ouputcmd = null;

        if ($type == "success"){
            $ouputcmd = "\n<info>".trim($text)."</info>\n";
        }
        elseif ($type == "error"){
            $ouputcmd = "\n<error>".trim($text)."</error>\n";
        }
        elseif ($type == "warning"){
            $ouputcmd = "\n<comment>".trim($text)."</comment>\n";
        }

        return $output->writeln($ouputcmd);
    }
}