<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};


// Autoloader, pour mieux gérer nos classes
require_once("vendor/autoload.php");

use Framework\LogWriting;

$log = new LogWriting();

try {
    $log->write("testlog.txt", "ERROR", "Bonjour je suis une ligne de log");
}
catch (Exception $e){
    echo $e;
}




?>
