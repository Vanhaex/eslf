<?php

$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};


// Autoloader, pour mieux gérer nos classes
require_once("vendor/autoload.php");

use Framework\LogWriting;






?>
