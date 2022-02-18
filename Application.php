<?php

require_once("vendor/autoload.php");

use Framework\Command\VersionCommand;
use Symfony\Component\Console\Application;

$namespace = "Framework\Command\\";

$application = new Application();

$commandArrays = [
    "AboutCommand",
    "VersionCommand"
];

foreach ($commandArrays as $cmd){
    $command = $namespace . $cmd;
    $application->add(new $command());
}

$application->add($default = new VersionCommand());

// La commande about par défaut qui présente le framework
$application->setDefaultCommand($default->getName());
$application->run();

?>