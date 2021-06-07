<?php

// Header
header("X-Frame-Options : sameorigin");
header("X-Content-Type-Options : nosniff");
header("X-XSS-Protection : 1;mode=block");
header("Content-Type : text/html");
header("Access-Control-Allow-Origin : *");

ini_set("session.cookie_httponly", 1);

ini_set("session.use_only_cookies", 1);

$path = $_SERVER['DOCUMENT_ROOT'];
$current_include_path = get_include_path();
if (stristr($path, $current_include_path) == false) {
  set_include_path(get_include_path() . PATH_SEPARATOR . $path);
};

// Autoloader
require_once("../vendor/autoload.php");

?>
